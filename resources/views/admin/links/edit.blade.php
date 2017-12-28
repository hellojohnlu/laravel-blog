@extends('admin.layout')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 编辑文章分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>分类管理</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/category/create') }}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{ url('admin/category') }}"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        @if(count($errors) > 0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p style="color: red;">{{ $error }}</p>
                    @endforeach
                @else
                    <p style="color: red;">{{ $errors }}</p>
                @endif
            </div>
        @endif
        <form action="{{ url('admin/category/'.$field->cate_id) }}" method="POST">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="cate_pid">
                                <option value="">==顶级分类==</option>
                                @foreach($data as $v)
                                <option value="{{ $v->cate_id }}"
                                    @if($v->cate_id == $field->cate_pid) selected @endif
                                >{{ $v->cate_name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类名称：</th>
                        <td>
                            <input type="text" name="cate_name" value="{{ $field->cate_name }}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="cate_title" value="{{ $field->cate_title }}">
                        </td>
                    </tr>
                    {{--<tr>--}}
                        {{--<th>作者：</th>--}}
                        {{--<td>--}}
                            {{--<input type="text" name="">--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <textarea class="lg" name="cate_keywords">{{ $field->cate_keywords }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="cate_description">{{ $field->cate_description }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="cate_order" value="{{ $field->cate_order }}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection