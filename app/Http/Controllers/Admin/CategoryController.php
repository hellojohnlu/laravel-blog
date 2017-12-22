<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    /**
     * 全部分类列表  GET.admin/category
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (new Category())->tree();
        return view('admin.category.index')->with('data',$data);
    }

    /**
     * 添加分类  GET.admin/category/create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();   //获取文章的顶级分类
        return view('admin/category/add',compact('data'));
    }

    /**
     * 添加分类的提交处理 P0ST.admin/category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->except('_token');    //排除_token值

            // 定义验证规则
            $rules = [
                'cate_name'    =>  'required',
            ];

            // 提示信息
            $messages = [
                'cate_name.required'   =>  '分类名称是必填字段',
            ];

            $validator = Validator::make($input, $rules, $messages);    //调用验证器

            if ($validator->passes()) {
                $res = Category::create($input);    //数据入库
                if ($res) {
                    return redirect('admin/jump')->with(['message'=>'添加分类成功！','url' =>'category', 'jumpTime'=>3,'status'=>true]);
                }else{
                    return back()->with('errors','添加分类失败，请稍后重试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
    }

    /**
     * 显示单个分类信息  GET.admin/category/{category}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑分类  GET.admin/category/{category}/edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);  //查询数据
        $data = Category::where('cate_pid',0)->get();   //获取文章的顶级分类
        return view('admin.category.edit',compact('field','data'));
    }

    /**
     * 更新分类  GET.admin/category/{category}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cate_id)
    {
        if ($request->isMethod('PUT')) {
            $input = $request->except('_token','_method');  //排除_token与_method值

            $res = Category::where('cate_id',$cate_id)->update($input);
            if ($res) {
                return redirect('admin/jump')->with(['message'=>'修改分类成功！','url' =>'category', 'jumpTime'=>3,'status'=>true]);
            }else{
                return back()->with('errors','修改分类失败，请稍后重试！');
            }
        }
    }

    /**
     * 删除分类  DELETE.admin/category/{category}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Category::where('cate_id',$id)->delete();    // 删除分类

        //如果删除的分类下有子分类，则把子分类变成顶级分类
        Category::where('cate_pid',$id)->update(['cate_pid'=>0]);

        if ($res) {
            $data = [
                'status'    =>  1,
                'msg'       =>  '删除分类成功'
            ];
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '删除分类失败，请稍后重试'
            ];
        }
        return $data;
    }


    /**
     * Ajax 异步实现分类排序
     *
     * @param Request $request
     * @return array
     */
    public function changeOrder(Request $request)
    {
        $input = $request->all();
        $cate = Category::find($input['cate_id']);  //取数据

        // 判断传递的值是否是数字
        if (is_numeric($input['cate_order'])) {
            $cate->cate_order = $input['cate_order'];   //赋值
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
                'msg'       =>  '分类排序更新成功'
            ];
        }else{
            $data = [
                'status'    =>  0,
                'msg'       =>  '分类排序更新失败'
            ];
        }

        return $data;   // 返回 JSON 数据
    }
}
