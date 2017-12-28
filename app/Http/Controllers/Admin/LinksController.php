<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
     * Show the form for creating a new resource.  GET->admin/links/create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. POST->admin/links
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.  GET->admin/links/{links}/edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.  PUT->admin/links/{links}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.  DELETE->admin/links/{links}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Ajax 异步刷新排序
     * @param Request $request
     * @return array
     */
    public function changeOrder(Request $request)
    {
        $input = $request->all();
        $cate = Links::find($input['link_id']);  //取数据

        // 判断传递的值是否是数字
        if (is_numeric($input['link_order'])) {
            $cate->link_order = $input['link_order'];   //赋值
            $res = $cate->update();                     //更新
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
