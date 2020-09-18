<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta http-equiv="Cache" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('meta')

    @show
    <link rel="stylesheet" href="{{ asset('static/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap.css') }}">
    
    <title>@yield('title', 'Laravel-demo')</title>
</head>
<body>
    <!-- nav -->
    <!-- loging & register  -->
    @include('common.nav')
    @include('common.reglogin')
    @section('reglogin')
    
    @show
    


    <!-- mainText -->
    @section('maintext')
    
    @show
    
    <!-- footer -->
    @include('common.footer')

    @section('js')
    @show
    <script src="{{ asset('static/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('static/js/popper.min.js') }}"></script>
    <script src="{{ asset('static/js/bootstrap.js') }}"></script>
    <script src="{{ asset('static/js/common.js') }}"></script>
    <script>
        function logined(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: $("#login-btn").attr("data-purl"),
                success: data=>{
                    if(data=="logined"){
                        $("#login-btn").attr("onclick", "window.location.href='"+$("#login-btn").attr("data-url")+"'").removeAttr("data-toggle").html("<img style='max-width:38px;height:auto' src='__ROOT__/{$data.avatar_url}avatar_38.jpg'>").addClass("p-0").removeClass("btn-block")
                    }else{
                        $("#login-btn").removeAttr("onclick").attr('data-togle', 'modal').html("登录").removeClass("p-0")
                    };
                }
            })
        }
        $(document).ready(function(){
            logined()
            $("#index-page").addClass("active")
            $.ajax({
                type: "POST",
                url: "{{ url('cookielogin') }}",
                success: data=>{
                    if(data=="success"){
                        location.reload()
                    }
                }
            })
        })
    </script>
    
</body>
</html>