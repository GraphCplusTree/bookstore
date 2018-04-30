<!doctype html>

<html lang="zh">

<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- JavaScript needed -->

    <script type="text/javascript"  src="{{asset('jquery/dist/jquery.js')}}"></script>

    <script src="{{asset('js/ajax-jquery-1.8.0.js')}}"></script>

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{asset('bootstrap-4.0.0/dist/css/bootstrap.min.css')}}">

    <!-- Icon Css -->

    <link rel="stylesheet" href="{{asset('open-iconic-master/font/css/open-iconic-bootstrap.css')}}">

    <!-- Custom Css -->

    <link rel="stylesheet" href="{{asset('css/sty.css')}}">

    {{--重写的 一些 style--}}

    @yield('style')

    <title>WebbookStore</title>

</head>

<body>

<!-- begin of the nav -->

<nav class="navbar navbar-dark navbar-expand-md bg-blue box-shadow" >

    <a href="{{url('admin/home')}}" class="navbar-brand">Bookshop</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynavbar" aria-controls="mynavbar" aria-expanded="false" aria-label="Toggle navigation">

        <span class="oi oi-aperture"></span>

    </button>

    <div class="collapse navbar-collapse high_light" id="mynavbar">

        <ul class="navbar-nav">

            <!-- 需要添加链接地址 -->

            <li class="nav-item"><a href="{{url('admin/home')}}" class="nav-link" title="sale">售书区<span class="sr-only">(current)</span></a></li>

            <li class="nav-item"><a href="{{url('admin/demand')}}" class="nav-link" title="demand">求书区</a></li>

            <li class="nav-item"><a href="#" class="nav-link">出借区</a></li>

        </ul>

        <div id="custom-search-input" class="ml-auto">

            <div class="input-group">

                <input type="text" class="search-query form-control" placeholder="   关键字搜索" />

                <span class="input-group-btn">

                 <button class="btn btn-danger" type="button" id="searchbtn">

                     <span class="oi oi-magnifying-glass"></span>

                 </button>

             </span>

            </div>

        </div>

        <div id="nav-user">

            <!-- 需要读用户名 -->

            <a href="{{url('admin/uploadinformationview')}}" id="namefetch"">

            @yield('namefetch')

            </a>

        </div>



        {{--增加一个 一个 和 用户名 并列的 "退出登陆"--}}

        <div>


            <a href="{{url('admin/quit')}}" class="nav-link">退出登陆</a>


        </div>

        {{--增加的  那一行结束了 --}}

    </div>

</nav>

<br>

<!-- end of the nav -->

    @yield('content')

</body>


@yield('script')


<!-- Optional JavaScript -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="{{asset('jquery/dist/jquery.slim.min.js')}}"></script>

<script src="{{asset('bootstrap-4.0.0/assets/js/vendor/popper.min.js')}}"></script>

{{--<script src="{{asset('bootstrap-4.0.0/dist/js/bootstrap.min.js')}}"></script>--}}

<script type="text/javascript" src="{{asset('org/layer/layer.js')}}"></script>

{{--公有 需要继承的 脚本--}}

<script>

    /*
    *  导航栏中的 高亮设置
    *
    */
    $(document).ready(function(e){

            var url=window.location.href;  //判断当前 url(字符串)

            var div_navbar=$("div.high_light ul li a"); //jQuery 选择器 选取 对应的 Dom 元素 或者 Dom元素数组

            for(var i=0;i<div_navbar.length;i++){

                if(url==div_navbar[i].href){

                    $(div_navbar[i]).addClass("active").siblings().removeClass("active");  //注意移除 其 兄弟节点(兄弟对象) 的active 类

                    break;

                }

            }

        }

    );

</script>


</body>

</html>
