<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * 网站配置项列表  GET->admin/config
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get(); //获取数据

        // 内容项
        foreach ($data as $k => $v) {
            switch ($v->field_type) {
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    if($v->field_value == 1){
                        $data[$k]->_html = '<input type="radio" name="conf_content[]" value="{{ $v->field_value}}" checked>开启 &nbsp;&nbsp;&nbsp;';
                        $data[$k]->_html .= '<input type="radio" name="conf_content[]" value="{{ $v->field_value}}">关闭';
                    }
                    break;
            }
        }

        return view('admin.config.index',compact('data'));
    }

    /**
     * 添加网站配置项  GET->admin/config/create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin.config.add',compact('data'));
    }

    /**
     * 添加网站配置项,处理表单提交  POST->admin/config
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token'); // 接收数据

            // 定义验证规则
            $rules = [
                'conf_title'    =>  'required',
                'conf_name'    =>  'required',
            ];

            // 提示信息
            $messages = [
                'conf_title.required'   =>  '请填写网站配置项标题',
                'conf_name.required'    =>  '请填写网站配置项名称',
            ];

            $validator = Validator::make($data, $rules, $messages);    //调用验证器

            if ($validator->passes()) {
                $res = Config::create($data);    //数据入库
                if ($res) {
                    return redirect('admin/jump')->with(['message'=>'添加网站配置项成功！','url' =>'config', 'jumpTime'=>3,'status'=>true]);
                }else{
                    return back()->with('errors','添加网站配置项失败，请稍后重试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
    }

    /**
     * Display the specified resource.  GET->admin/config/{config}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑网站配置项  GET->admin/config/{config}/edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Config::find($id);  // 获取数据
        return view('admin.config.edit',compact('field'));
    }

    /**
     * 更新网站配置项  PUT->admin/config/{config}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('PUT')) {
            $input = $request->except('_token','_method');  //排除_token与_method值

            $res = Config::where('conf_id',$id)->update($input);
            if ($res) {
                $this->putFile();
                return redirect('admin/jump')->with(['message'=>'更新配置项成功！','url' =>'config', 'jumpTime'=>3,'status'=>true]);
            }else{
                return back()->with('errors','更新配置项失败，请稍后重试！');
            }
        }
    }

    /**
     * 删除网站配置项  DELETE->admin/config/{config}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Config::where('conf_id',$id)->delete();    // 删除分类

        if ($res) {
            $data = [
                'status'    =>  1,
                'msg'       =>  '删除网站配置项成功！'
            ];
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '删除网站配置项失败，请重试！'
            ];
        }
        $this->putFile();
        return $data;
    }

    /**
     * Ajax 异步刷新排序
     * @param Request $request
     * @return array
     */
    public function changeOrder(Request $request)
    {
        $input = $request->all();
        $nav = Config::find($input['conf_id']);  //取数据

        // 判断传递的值是否是数字
        if (is_numeric($input['conf_order'])) {
            $nav->conf_order = $input['conf_order'];   //赋值
            $res = $nav->update();                     //更新
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '输入的不是数字，请检查！',
            ];
            return $data;
        }

        // 判断是否更新成功
        if ($res) {
            $data = [
                'status'    =>  1,
                'msg'       =>  '排序更新成功'
            ];
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '排序更新失败'
            ];
        }

        return $data;   // 返回 JSON 数据
    }

    /**
     * 网站内容
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeContent(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();    // 获取表单数据
            foreach ($data['conf_id'] as $k => $v) {
                Config::where('conf_id',$v)->update(['conf_content'=>$data['conf_content'][$k]]);
            }
        }
        $this->putFile();
        return back()->with('errors','配置项更新成功！');
    }

    /**
     * 生成网站配置项文件
     */
    public function putFile()
    {
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\conf.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
}
