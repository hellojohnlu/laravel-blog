<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Storage;
use App\Http\Requests;

class ArticleController extends CommonController
{
    /**
     * 文章列表 Get->admin/article
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'All articles';
    }

    /**
     * 写文章  GET->admin/article/create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Category)->tree(); // 获取文章分类
        return view('admin.article.add',compact('data'));
    }

    /**
     * 写文章  POST->admin/article
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 文章图片上传
        if ($request->isMethod('post')) {

            $file = $request->file('picture');

            // 文件是否上传成功
            if ($file->isValid()) {

                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                $filename = date('YmdHis') . uniqid() . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                var_dump($bool);
            }
        }
    }

    /**
     * Display the specified resource.  GET->admin/article/{article}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑文章  GET->admin/article/{article}/edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.  PUT->admin/article/{article}
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
     * Remove the specified resource from storage.  DELETE->admin/article/{article}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
