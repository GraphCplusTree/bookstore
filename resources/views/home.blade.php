@extends('common.layout')

@section('namefetch')

  <h5>{{$user_name}}</h5>

@stop

@section('content')

    <div class="col-9">{{--占据左边9列，留下余量--}}

        {{--右边第一行--}}

        {{--需要注意以后书目增多之后的分页--}}

        <?php

       $array_len=count($newdatas);

       $count=$array_len-1;

        ?>

        <div class="row">

            <!-- begining of a book item -->

            <div class="col-lg-4 no-padding book-item" data-catagory="view">

                <div class="container book-panel box-shadow">

                    <div class="row">

                        <div class="col-md-6">


                            <a href="{{url('admin/uploadview')}}"><img src="{{asset('img/upload.jpg')}}" alt="here should be the picture of book1, however it can't be load due to the bad internet connection" class="book-preview"></a>

                        </div>

                        <div class="col-sm-6 info-holder">

                            <div class="container">

                                <div class="row">

                                    <div class="col-md-12">

                                        <h3 class="info-header">上传</h3>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-9"><h4>就是你</h4></div>

                                    <div class="col-md-3 info-price"></div>

                                </div>

                                <div class="row">

                                    <div class="col-md-9">

                                        <p clsaa="info-briefintro">上传你的愿望</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row info-uploader">

                        <h6 class="col-md-4 info-uploader-name"><a href="database/user/user1.html"><span class="oi oi-person"></span>你的名字</a></h6>

                        <h6 class="info-uploadtime col-md-5"><sapn class="oi oi-clock"></sapn>就是现在</h6>

                        <h6 class="info-viewcount col-md-3"><span class="oi oi-eye"></span>20</h6>

                    </div>

                </div>

            </div>

            <!-- end of a book item -->


        @for($j=0;$j<$array_len;$j++)

            <!-- the begining of a book item -->

                <div class="col-lg-4 no-padding book-item" data-catagory="view">

                    <div class="container book-panel box-shadow">

                        <div class="row">

                            <div class="col-md-6">

                                {{--这里需要 给每一个 上传 用户 的图书卡片 中的 详情 一个链接 并且 需要 上传者 的用户信息中的 书籍 ID 和用户者信息 ID 进行 可选参数路由 的传递 --}}

                                {{--因此，这里 需要用到 嵌套 一个 PHP 脚本 构造出 两个变量 以便 在 Blade 模版引擎 中的 语法中 引用--}}

                                <?php

                                $book_id=$newdatas[$count--]->book_id;

                                $student_id=$newdatas[$count+1]->book_belongto;

                                ?>

            <a href="{{url("admin/action/$book_id/bookbelong/$student_id")}}"><img src="{{$newdatas[$count+1]->book_photo}}" alt="here should be the picture of book1, however it can't be load due to the bad internet connection" class="book-preview"></a>

                            </div>

                            <div class="col-sm-6 info-holder">

                                <div class="container">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <h3 class="info-header">{{$newdatas[$count+1]->book_name}}</h3>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-9"><h4>{{$newdatas[$count+1]->book_author}}</h4></div>

                                        <div class="col-md-3 info-price">￥{{$newdatas[$count+1]->price}}</div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-9">

                                            <p clsaa="info-briefintro">详情点击图片</p>

                                        </div>

                                    </div>

                                </div>

      </div>

                        </div>

                        <div class="row info-uploader">

                            <h6 class="col-md-4 info-uploader-name"><a href="{{url("admin/action/$book_id/bookbelong/$student_id")}}"><span class="oi oi-person"></span>{{$newdatas[$count+1]->book_owner}}</a></h6>

                            <h6 class="info-uploadtime col-md-5"><span class="oi oi-clock"></span>{{$newdatas[$count+1]->book_uptime}}</h6>

                            <h6 class="info-viewcount col-md-3"><span class="oi oi-eye"></span>40</h6>

                        </div>

                    </div>

                </div>

                <!-- the end of a book item -->

            @endfor

        </div>{{--行 结束位置--}}

    </div>{{--左边 9 列 结束--}}

    {{--////////--}}


@stop
        @section('script')

            <script type="text/javascript">


                jQuery(function(){

                    jQuery.noConflict();

                    timestamp=0;    //时间戳  进行 与数据库 中的 数据进行对比

                    $.post(

                        "{{url('admin/chat')}}",   //发送 的目的地

                        {
                            time:timestamp,

                            act:'updatemsg',

                            _token:'{{csrf_token()}}'

                        },  //发送的 携带的 数据：使用 javascript 对象

                        function (data) {   //callback function

                            if (!data[0].time)

                                return;

                            else {

                                if(null !=data && "" !=data) {  //js 的回调函数 中 判断 回调 传过来的 参数 是否为空 的方法

                                    jQuery.each(data, function (idx, ret_data) { //回传到 回调 函数 中 的参数 ，一个是 下标 另一个是 对象的引用

                                        var author = this.chat_student_id;

                                        var content = this.chat_student_messages;

                                        var str = jQuery("#mytext").val();

                                        str += author + ":" + content + "\r\n";

                                        jQuery("#mytext").val(str);


                                        var show = jQuery("#mytext")[0];

                                        show.scrollTop = show.scrollHeight;

                                    });

                                }

                                else return;

                            }

                        }

                    );

                });


                /*
                *websocket tcp连接代码：用来评论区内部的通信
                *
                *
                * 客户端 websocket
                 */

                jQuery(function(){


                    wsSever='ws://127.0.0.1:9502';

                    websocket=new WebSocket(wsSever);


                    //连接正常 后的 回调函数

                    websocket.onopen=function (ev) {

                    };

                    websocket.onmessage=function (ev) {

                        //使用 JSON.parse(json对象) 解析json 为  JavaScript 对象

                        var data=JSON.parse(ev.data);

                        var content =data.student_messages;

                        var str=jQuery("#mytext").val();

                        str+=content+"\r\n";

                        jQuery("#mytext").val(str);

                        var show=jQuery("#mytext")[0];

                        show.scrollTop = show.scrollHeight;

                    };

                    jQuery("#chatform").submit(function () {

                        jQuery.noConflict();

                        var message=jQuery("#msg").val();

                        var user=$("input[name=hide_information]").attr("value");




                        var infor= new Array();

                        infor[0]=user;

                        infor[1]=message;

                        var sent=infor[0]+":"+infor[1];

                        /*
                        *向 服务器 端 推送信息
                        *
                         */

                        websocket.send(sent);

                        jQuery('#msg').val("");

                        return false;

                    });

                });

            </script>


@stop