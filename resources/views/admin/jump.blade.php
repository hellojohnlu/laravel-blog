<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('admin/js/jquery.js')}}"></script>
    <title>跳转页面</title>
    <style>
        .wrapper-page{
            max-width: 400px;
            margin: 50px auto 10px;
            color: #333;
            border: 5px ridge darkseagreen;
            padding-bottom: 20px;
        }
        .text-center{
            text-align: center;
        }
        .panel-heading{
            font-size: 1.2rem;
        }
        .button{
            padding-top: 20px;
        }
        .btn-success,.btn-danger{
            border: solid 2px limegreen;
            border-radius: 5px;
            width: 100px;
            height: 30px;
            background-color: #eee;
            cursor: pointer;
        }
        .btn-danger{
            border: solid 2px red;
            border-radius: 5px;
            width: 100px;
            height: 30px;
            background-color: #eee;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="wrapper-page">
    <div class="panel panel-color {{ $data['status'] ? 'panel-inverse':'panel-danger' }}">

        <div class="panel-heading">
            <h3 class="text-center">{{ $data['message'] }}</h3>
        </div>

        <div class="panel-body">
            <div class="text-center">
                <div class="alert {{ $data['status']?'alert-info':'alert-danger' }} alert-dismissable">
                    浏览器页面将在 <b id="loginTime">{{ $data['jumpTime'] }}</b> 秒后跳转......
                </div>
                <div class="button">
                    <button class="btn {{ $data['status']?'btn-success':'btn-danger' }}">点击立即跳转</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/jquery.js"></script>
<script type="text/javascript">
    $(function(){
        //循环倒计时，并跳转
        var url = "{{ $data['url'] }}";
        var loginTime = parseInt($('#loginTime').text());
        console.log(loginTime);
        var time = setInterval(function(){
            loginTime = loginTime-1;
            $('#loginTime').text(loginTime);
            if(loginTime==0){
                clearInterval(time);
                window.location.href=url;
            }
        },1000);
    })
    //点击跳转
    $('.btn-success').click(function () {
        var url = "{{ $data['url'] }}";
        window.location.href=url;
    })
</script>
</body>
</html>