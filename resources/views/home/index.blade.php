﻿@extends('home.layout')

@section('info')
  <title>{{ Config::get('conf.myBlog') }}</title>
  <meta name="keywords" content="{{ Config::get('conf.keywords') }}" />
  <meta name="description" content="{{ Config::get('conf.description') }}" />
@endsection

@section('content')
<div class="banner">
  <section class="box">
    <ul class="texts">
      <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
      <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
      <p>加了锁的青春，不会再因谁而推开心门。</p>
    </ul>
    <div class="avatar"><a href="#"><span>后盾</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>热读文章</span> Hot article</p>
    </h3>
    <ul>
      @foreach($hotArticle as $h)
        <li><a href="{{ url('article/'.$h->art_id) }}"  target="_blank"><img src="{{ '/uploads/'.$h->art_thumb }}"></a><span>{{ $h->art_title }}</span></li>
      @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">

    {{--文章列表--}}
    @foreach($data as $d)
      <h3>{{ $d->art_title }}</h3>
      <figure><img src="{{ 'uploads/'.$d->art_thumb }}" width="200" height="120"></figure>
      <ul>
        <p>{{ $d->art_description }}</p>
        <a title="{{ $d->art_title }}" href="{{ url('article/'.$d->art_id) }}" target="_blank" class="readmore">阅读全文>></a>
      </ul>
      <p class="dateview">&nbsp;<span>{{ date('Y-m-d H:i',$d->art_time) }}</span><span>作者：{{ $d->art_editor }}</span></p>
    @endforeach

    {{--分页--}}
      <div class="page">
        {{ $data->links() }}
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

    {{--最新文章--}}
    <div class="news" style="float: left">
    <h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
      @foreach($newArticle as $n)
      <li><a href="{{ url('article/'.$n->art_id) }}" target="_blank">{{ $n->art_title }}</a></li>
      @endforeach
    </ul>

    {{--随机文章--}}
    <h3 class="ph">
      <p>随机<span>文章</span></p>
    </h3>
    <ul class="paih">
      @foreach($randomArticle as $r)
      <li><a href="{{ url('article/'.$r->art_id) }}" target="_blank">{{ $r->art_title }}</a></li>
      @endforeach
    </ul>

    {{--友情链接--}}
    <h3 class="links">
      <p>友情<span>链接</span></p>
    </h3>
    <ul class="website">
      @foreach($links as $l)
      <li><a href="{{ $l->link_url }}" target="_blank">{{ $l->link_name }}</a></li>
      @endforeach
    </ul> 
    </div>

    </aside>
</article>
@endsection