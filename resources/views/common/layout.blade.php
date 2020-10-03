<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
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
    @section('reglogin')
    
    @show
    


    <!-- mainText -->
    @section('maintext')
    
    @show
    
    <!-- footer -->
    @include('common.footer')

    
    <script src="{{ asset('static/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('static/js/popper.min.js') }}"></script>
    <script src="{{ asset('static/js/bootstrap.js') }}"></script>
    @section('js')
        
    @show
    <script>
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "POST",
                    url: "{{ url('login/cookieLogin') }}",
                    success: data=>{
                        if(data.success){
                            location.reload()
                        }
                    }
                })
                $(".oauth-login").click(function(){
                    var url = $(this).data("login-url")
                    window.screenLeft
                    window.open(url, '_blank', "top=100, left=400, toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=800, height=600")
                })
            })
        </script>
</body>
</html>