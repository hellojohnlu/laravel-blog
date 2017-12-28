<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $data = Article::orderBy('art_id','desc')->paginate(5);   // 获取文章数据
        return view('admin.article.index',compact('data',$data));
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

            $data = $request->except('_token','picture');
            $file = $request->file('picture');

            $data['art_time'] = time();

            if (!$file) {
                return back()->with('errors','请选择文章缩略图！');
            }

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
                if ($bool) {
                    $data['art_thumb'] = substr(Storage::url($filename),9); // 保存图片路径，只保存文件名
                }
            }

            // 定义验证规则
            $rules = [
                'art_title'    =>  'required',
                'art_content'  =>  'required',
            ];

            // 提示信息
            $messages = [
                'art_title.required'   =>  '请填写文章标题',
                'art_content.required' =>  '请填写文章内容',
            ];

            $validator = Validator::make($data, $rules, $messages);    //调用验证器

            if ($validator->passes()) {
                $res = Article::create($data);  //数据入库
                if ($res) {
                    return redirect('admin/jump')->with(['message'=>'发布文章成功','url' =>'article', 'jumpTime'=>3,'status'=>true]);
                }else{
                    return back()->with('errors','发布文章失败，请重试！');
                }
            }else{
                return back()->withErrors($validator);
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
        $data = (new Category)->tree(); // 获取文章分类

        $field = Article::find($id);

        return view('admin.article.edit',compact('data','field'));
    }

    /**
     * 编辑文章处理提交  PUT->admin/article/{article}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $data = $request->except('_token','picture','_method');
            $file = $request->file('picture');

            if (!empty($file)) {
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
                    if ($bool) {
                        $data['art_thumb'] = substr(Storage::url($filename),9); // 保存图片路径，只保存文件名
                    }
                }
            }

            $res = Article::where('art_id',$id)->update($data); // 更新文章

            if ($res) {
                return redirect('admin/jump')->with(['message'=>'更新文章成功','url' =>'article', 'jumpTime'=>3,'status'=>true]);
            }else{
                return back()->with('errors','更新文章失败！');
            }
        }
    }

    /**
     * 删除文章  DELETE->admin/article/{article}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Article::where('art_id',$id)->delete();    // 删除文章

        if ($res) {
            $data = [
                'status'    =>  1,
                'msg'       =>  '删除文章成功'
            ];
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '删除文章失败，请稍后重试'
            ];
        }
        return $data;
    }
}
