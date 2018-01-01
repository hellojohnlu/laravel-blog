<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    /**
     * 友情链接列表  GET->admin/links
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin.links.index',compact('data'));
    }

    /**
     * 添加友情链接  GET->admin/links/create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin.links.add',compact('data'));
    }

    /**
     * 添加友情链接,处理表单提交  POST->admin/links
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
                'link_name'    =>  'required',
                'link_url'    =>  'required',
            ];

            // 提示信息
            $messages = [
                'link_name.required'   =>  '请填写链接名称',
                'link_url.required'    =>  '请填写 URL 地址',
            ];

            $validator = Validator::make($data, $rules, $messages);    //调用验证器

            if ($validator->passes()) {
                $res = Links::create($data);    //数据入库
                if ($res) {
                    return redirect('admin/jump')->with(['message'=>'添加友情链接成功！','url' =>'links', 'jumpTime'=>3,'status'=>true]);
                }else{
                    return back()->with('errors','添加友情链接失败，请稍后重试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
    }

    /**
     * Display the specified resource.  GET->admin/links/{links}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑友情链接  GET->admin/links/{links}/edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Links::find($id);  // 获取数据
        return view('admin.links.edit',compact('field'));
    }

    /**
     * 更新友情链接  PUT->admin/links/{links}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('PUT')) {
            $input = $request->except('_token','_method');  //排除_token与_method值

            $res = Links::where('link_id',$id)->update($input);
            if ($res) {
                return redirect('admin/jump')->with(['message'=>'修改分类成功！','url' =>'links', 'jumpTime'=>3,'status'=>true]);
            }else{
                return back()->with('errors','修改分类失败，请稍后重试！');
            }
        }
    }

    /**
     * 删除友情链接  DELETE->admin/links/{links}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Links::where('link_id',$id)->delete();    // 删除分类

        if ($res) {
            $data = [
                'status'    =>  1,
                'msg'       =>  '删除友情链接成功！'
            ];
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '删除友情链接失败，请重试！'
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
        $link = Links::find($input['link_id']);  //取数据

        // 判断传递的值是否是数字
        if (is_numeric($input['link_order'])) {
            $link->link_order = $input['link_order'];   //赋值
            $res = $link->update();                     //更新
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
