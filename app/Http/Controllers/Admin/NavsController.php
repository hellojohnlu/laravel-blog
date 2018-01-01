<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    /**
     * 导航菜单列表  GET->admin/Navs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin.Navs.index',compact('data'));
    }

    /**
     * 添加导航菜单  GET->admin/Navs/create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin.Navs.add',compact('data'));
    }

    /**
     * 添加导航菜单,处理表单提交  POST->admin/Navs
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
                'nav_name'    =>  'required',
                'nav_url'    =>  'required',
            ];

            // 提示信息
            $messages = [
                'nav_name.required'   =>  '请填写导航名称',
                'nav_url.required'    =>  '请填写 URL 地址',
            ];

            $validator = Validator::make($data, $rules, $messages);    //调用验证器

            if ($validator->passes()) {
                $res = Navs::create($data);    //数据入库
                if ($res) {
                    return redirect('admin/jump')->with(['message'=>'添加导航菜单成功！','url' =>'navs', 'jumpTime'=>3,'status'=>true]);
                }else{
                    return back()->with('errors','添加导航菜单失败，请稍后重试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
    }

    /**
     * Display the specified resource.  GET->admin/Navs/{Navs}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑导航菜单  GET->admin/Navs/{Navs}/edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Navs::find($id);  // 获取数据
        return view('admin.Navs.edit',compact('field'));
    }

    /**
     * 更新导航菜单  PUT->admin/Navs/{Navs}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('PUT')) {
            $input = $request->except('_token','_method');  //排除_token与_method值

            $res = Navs::where('nav_id',$id)->update($input);
            if ($res) {
                return redirect('admin/jump')->with(['message'=>'更新导航成功！','url' =>'navs', 'jumpTime'=>3,'status'=>true]);
            }else{
                return back()->with('errors','更新导航失败，请稍后重试！');
            }
        }
    }

    /**
     * 删除导航菜单  DELETE->admin/Navs/{Navs}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Navs::where('nav_id',$id)->delete();    // 删除分类

        if ($res) {
            $data = [
                'status'    =>  1,
                'msg'       =>  '删除导航菜单成功！'
            ];
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '删除导航菜单失败，请重试！'
            ];
        }
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
        $nav = Navs::find($input['nav_id']);  //取数据

        // 判断传递的值是否是数字
        if (is_numeric($input['nav_order'])) {
            $nav->nav_order = $input['nav_order'];   //赋值
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
}
