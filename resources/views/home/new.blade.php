@extends('home.layout')

@section('info')
  <title>{{ $data->art_title }} —— {{ Config::get('conf.myBlog') }}</title>
  <meta name="keywords" content="{{ $data->art_tag }}" />
  <meta name="description" content="{{ $data->art_title }}" />
@endsection

@section('content')
<article class="blogs">
  <h1 class="t_nav">
    <span><div style="float: left">您当前的位置：</div><a href="{{url('/')}}">首页</a> &gt; <a href="{{url('cate/'.$data->cate_id)}}">{{$data->cate_name}}</a></span>
    <a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$data->cate_id)}}" class="n2">{{$data->cate_name}}</a>
  </h1>

  <div class="index_about">
    <h2 class="c_titile">{{$data->art_title}}</h2>
    <p class="box_c"><span class="d_time">{{date('Y-m-d H:i',$data->art_time)}}</span><span>编辑：{{$data->art_editor}}</span><span>查看次数：{{$data->art_view}}</span></p>
    <ul class="infos">
      <p>{!! $data->art_content !!}</p>
    </ul>
    <div class="keybq">
    <p><span>关键字词</span>：{{$data->art_tag}}</p>

    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
      <p>上一篇：
        @if($article['pre'])
          <a href="{{url('article/'.$article['pre']->art_id)}}">{{$article['pre']->art_title}}</a>
        @else
          <span>没有了</span>
        @endif
      </p>
      <p>下一篇：
        @if($article['next'])
          <a href="{{url('article/'.$article['next']->art_id)}}">{{$article['next']->art_title}}</a>
        @else
          <span>没有了</span>
        @endif
      </p>
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        @foreach($r_data as $d)
        <li><a href="{{url('article/'.$d->art_id)}}" title="{{$d->art_title}}">{{$d->art_title}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  <aside class="right">
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
    <script type="text/javascript" id="bdshell_js"></script> 
    <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script> 
    <!-- Baidu Button END -->
    <div class="blank"></div>

    <div class="news">
      @parent
    </div>
  </aside>
</article>
@endsection