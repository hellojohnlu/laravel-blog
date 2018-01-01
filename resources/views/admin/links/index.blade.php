@extends('admin.layout')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接
    </div>
    <!--面包屑导航 结束-->

    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>友情链接列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/links/create') }}"><i class="fa fa-plus"></i>添加友情链接</a>
                    <a href="{{ url('admin/links') }}"><i class="fa fa-recycle"></i>全部友情链接</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>链接名称</th>
                        <th>链接标题</th>
                        <th>地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this, {{ $v->link_id }})" value="{{ $v->link_order }}">
                        </td>
                        <td class="tc">{{ $v->link_id }}</td>
                        <td>
                            <a href="#">{{ $v->link_name }}</a>
                        </td>
                        <td>{{ $v->link_title }}</td>
                        <td>{{ $v->link_url }}</td>
                        <td>
                            <a href="{{ url('admin/links/'.$v->link_id.'/edit') }}">修改</a>
                            <a href="javascript:;" onclick="delLink({{ $v->link_id }})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
<script>
    {{--Ajax 异步加载，分类排序--}}
    function changeOrder(obj,link_id) {
        var link_order = $(obj).val();
        $.post("{{ url('admin/links/changeOrder') }}",{'_token':'{{csrf_token()}}','link_id':link_id,'link_order':link_order},function (data) {
            if(data.status == 1){   //如果更新排序成功
                layer.msg(data.msg,{icon:6});
                setTimeout("window.location.reload()",2000);    // 2 秒后刷新页面
            }else{
                layer.msg(data.msg,{icon:5});
            }
        });
    }

    // 删除分类
    function delLink(link_id) {
        //询问框
        layer.confirm('您确定要删除这条友情链接吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            // 异步删除分类
            $.post("{{url('admin/links/')}}/"+link_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                if(data.status == 1){
                    layer.msg(data.msg,{icon:6});
                    setTimeout("window.location.reload()",2000);    // 2 秒后刷新页面
                }else{
                    layer.msg(data.msg,{icon:5});
                }
            });
        }, function(){

        });
    }
</script>
@endsection