<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{asset('admin/css/admin.css')}}">
	<link rel="stylesheet" href="{{asset('admin/font/css/font-awesome.min.css')}}">
	<script type="text/javascript" src="{{asset('admin/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('layer/layer.js')}}"></script>
	<title>@yield('title')</title>
</head>
<body>
	@yield('content')
</body>
</html>