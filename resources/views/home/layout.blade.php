<!doctype html>
<html>
<head>
<meta charset="utf-8">
@yield('info')
<link href="{{asset('home/css/base.css')}}" rel="stylesheet">
<link href="{{asset('home/css/index.css')}}" rel="stylesheet">
  <link href="{{asset('home/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('home/css/new.css')}}" rel="stylesheet">
<!--[if lt IE 9]>
<script src="{{asset('home/js/modernizr.js')}}"></script>
<![endif]-->
</head>
<body>
<header>
  <div id="logo"><a href="{{url('/')}}"></a></div>
  <nav class="topnav" id="topnav">
    @foreach($navs as $k => $v)<a href="{{ $v->nav_url }}"><span>{{ $v->nav_name }}</span><span class="en">{{ $v->nav_alias }}</span></a>@endforeach
  </nav>
</header>

@section('content')
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
@show

<footer>
  <p><a href="{{ url('/') }}" target="_parent">{{ Config::get('conf.copyright') }}</a> @ {{date('Y',time())}}</p>
</footer>
</body>
</html>
