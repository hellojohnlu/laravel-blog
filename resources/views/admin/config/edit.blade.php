@extends('admin.layout')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 网站配置项管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改网站配置项</h3>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        @if(count($errors) > 0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p style="color: red;text-align: center">{{ $error }}</p>
                    @endforeach
                @else
                    <p style="color: red;text-align: center">{{ $errors }}</p>
                @endif
            </div>
        @endif
        <form action="{{ url('admin/config/'.$field->conf_id) }}" method="POST">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title" value="{{ $field->conf_title }}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="conf_name" value="{{ $field->conf_name }}">
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="field_type" value="input" @if($field->field_type == 'input') checked @endif onclick="showTr()">input &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="field_type" value="textarea" @if($field->field_type == 'textarea') checked @endif onclick="showTr()">textarea &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="field_type" value="radio" @if($field->field_type == 'radio') checked @endif onclick="showTr()">radio &nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr class="field_value">
                        <th>类型值：</th>
                        <td>
                            <input type="text" name="field_value" value="{{ $field->field_value }}">
                            <span>类型值在 radio 的情况下需要配置，格式：1->开启，0->关闭</span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="{{ $field->conf_order }}">
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea name="conf_tips" id="" cols="30" rows="10">{{ $field->conf_tips }}</textarea>
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

    <script>
        showTr();
        function showTr() {
            var type = $('input[name=field_type]:checked').val();
            if(type=='radio'){
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }
    </script>
@endsection