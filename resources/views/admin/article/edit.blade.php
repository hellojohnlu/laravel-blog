@extends('admin.layout')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 编辑文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>文章管理</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/article/create') }}"><i class="fa fa-plus"></i>写文章</a>
                <a href="{{ url('admin/article') }}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        @if(count($errors) > 0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p style="color: red; text-align: center;">{{ $error }}</p>
                    @endforeach
                @else
                        <p style="color: red; text-align: center;">{{ $errors }}</p>
                @endif
            </div>
        @endif

        <form action="{{ url('admin/article/'.$field->art_id) }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120">文章分类：</th>
                        <td>
                            <select name="cate_id">
                                @foreach($data as $v)
                                <option value="{{ $v->cate_id }}" @if($field->cate_id == $v->cate_id) selected @endif>{{ $v->_cate_name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title" value="{{ $field->art_title }}">
                        </td>
                    </tr>
                    <tr>
                        <th>编辑作者：</th>
                        <td>
                            <input type="text" name="art_editor" value="{{ $field->art_editor }}">
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <div><img src="{{url('uploads/'.$field->art_thumb)}}" alt="" width="200" height="120"></div>
                            <input type="text" name="art_thumb" value="{{ $field->art_thumb }}" style="display: none">
                            <input type="file" name="picture" id="picture" style="max-height: 200px;max-width: 350px;">
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag" value="{{ $field->art_tag }}">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_description">{{ $field->art_description }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>文章内容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.config.js') }}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/ueditor.all.min.js') }}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{ asset('ueditor/lang/zh-cn/zh-cn.js') }}"></script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
                            <script id="editor" name="art_content" type="text/plain" style="width: 100%;height:500px;">{!! $field->art_content !!}</script>
                            <script type="text/javascript">
                            //实例化编辑器
                            var ue = UE.getEditor('editor');
                            </script>
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