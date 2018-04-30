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

          <div class="row">{{--整个布局只有一行 2/10分--}}

            <div class="col-2">

                <div class="list-group" id="list">

                    <a href="{{url("admin/select/$title_category/left/economy")}}" class="list-group-item list-group-item-action" title="economy">经济学院</a>

                    <a href="{{url("admin/select/$title_category/left/law")}}" class="list-group-item list-group-item-action " title="law">法学院</a>

                    <a href="{{url("admin/select/$title_category/left/business")}}" class="list-group-item list-group-item-action " title="business">商学院</a>

                    <a href="{{url("admin/select/$title_category/left/history")}}" class="list-group-item list-group-item-action " title="history">历史学院</a>

                    <a href="{{url("admin/select/$title_category/left/math")}}" class="list-group-item list-group-item-action " title="math">数学学院</a>

                    <a href="{{url("admin/select/$title_category/left/physics")}}" class="list-group-item list-group-item-action " title="physics">物理学院</a>

                    <a href="{{url("admin/select/$title_category/left/foreign")}}" class="list-group-item list-group-item-action " title="foreign">外语学院</a>

                    <a href="{{url("admin/select/$title_category/left/literature")}}" class="list-group-item list-group-item-action " title="literature">文学院</a>

                    <br>

                    <div id="wrapper" class="box-shadow">

                        <textarea class="form-control" rows="10" id="mytext"></textarea>

                        <p id="messagewindow"><span id="loading">即时在线聊天空间🐶</span ></p>

                        <form id="chatform">

                            {{--在 laravel 框架中 凡是提交上 去的 表单域 都需要 经过 csrf_field() 认证--}}

                            {{csrf_field()}}

                            <div class="container">

                              <div class="row">

                                <input type="text" id="msg" class="col-xs-9" placeholder="一起交流吧"><br/>

                                <button type="submit" class="oi oi-bullhorn col-xs-3"></button><br>

                              </div>

                            </div>

                        </form>


                    </div>

                </div>

            </div>

              {{--在公有模版中 保证每一个页面  都会有一个 隐藏的 表单域 目的是为了在进行 websocket 传输 即时 的信息的 时候 同时 确认 发送者是谁 即 发送信息人 的具体学号 --}}

              <input type="hidden" name="hide_information" value="{{session('user')->student_id}}" />

              @yield('content')


        </div>{{--整个布局只有一行结束 2/10分--}}

</body>


@yield('script')


     <!-- Optional JavaScript -->

     <!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="{{asset('jquery/dist/jquery.slim.min.js')}}"></script>

<script src="{{asset('bootstrap-4.0.0/assets/js/vendor/popper.min.js')}}"></script>

{{--<script src="{{asset('bootstrap-4.0.0/dist/js/bootstrap.min.js')}}"></script>--}}

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
            /*
            *导航栏 每跳转到 对应的 导航 下面对应的 左边的列表第一行 代表的学院 高亮
            *
             */

       var list=$("#list a:first");

       list.addClass("active");

    }

    );

    /*
    *当你在 某一 导航栏中 确定的 栏目 条件下 再点击对应的 左边的 侧栏 的时候 ，那么 url 就会发生变化 变成了 一个带 两个参数的 url
    *
    * 这个时候 你写的 第一个 页面加载 的时候 执行的javascript 就 遍历完 也得不到 你想要的结果
    *
    * 这个时候 你需要 得到 目前 页面的 url ，并且 进行 字符串分割 解析 找到 对应的 sale 或者 demand 等等 类似的标签
    *
    * 然后  找到 对应的 title=sale或者demand 的Dom 元素节点对象 添加 active 类 并 注意 其 对应的 兄弟节点 对象的处理
    */

    $(document).ready(function(){


        var list=$("#list a");

        var url=window.location.href;

        var array=url.split("/");

        var string=array[5];

        if(typeof(array[5])=="undefined"){  //注意 未定义(未赋值) 字符串 即 undefined 类型的 判断

            return;


  }

  var dom=$("a[title="+string+"]");  //若需要 在 jQuery 的选择器中 使用变量 那么 使用 字符串 拼接的 方式

        dom.addClass("active").siblings().removeClass("active");


});

    /*
    *每一个 导航栏 下面的 侧栏 中的 对应的 每一个 条目 的高亮
    *
     */

    $(document).ready(function(){

        var url=window.location.href;

        var dom=$("#list a");

        for(var i=0;i<dom.length;i++){

            if(url==$(dom[i]).attr("href")){

            $(dom[i]).addClass("active").siblings().removeClass("active");

            break;
        }

    }

});




</script>


</body>

</html>
