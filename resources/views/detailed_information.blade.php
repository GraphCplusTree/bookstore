@extends('common/NoLeft_SideNote_Layout')

@section('namefetch')

<h5>{{$user_name}}</h5>

@stop

@section('content')

    {{--整个 包括 书籍 信息 和 上传者 信息 一行的  开始  --}}

    <div class="row">

        <div class="col-md-6">

            <table class="table table-bordered">

                <tbody>

                <tr>

                    <th scope="row">书名</th>

                    <td colspan="1">{{$bookdatas->book_name}}</td>

                </tr>

                <tr>

                    <th scope="row">作者</th>

                    <td colspan="1">{{$bookdatas->book_author}}</td>

                </tr>

                <tr>

            <th scope="row">出版社</th>

                    <td >{{$bookdatas->publishing_house}}</td>

        </tr>

        <tr>

            <th scope="row">价格</th>

            <td >{{$bookdatas->price}}</td>

        </tr>

                <tr>

                    <th scope="row" height="200">书籍介绍</th>

                    <td height="200">{{$bookdatas->book_introduction}}</td>

                </tr>

                </tbody>

            </table>

        </div>

        <div class="col-md-6 ">

            <table class="table table-bordered">

                <tbody>

                <tr>

                    <th scope="row">上传者</th>

                    <td colspan="1">{{$userdatas->user_name}}</td>

                </tr>

                <tr>

                    <th scope="row">性别</th>

                    <td>{{$userdatas->sex}}</td>

                </tr>

                <tr>

                    <th scope="row">校区</th>

                    <td >{{$userdatas->campus}}</td>


                </tr>

                <tr>

                    <th scope="row">邮箱</th>

                    <td >{{$userdatas->mail}}</td>

                </tr>

                <tr>

                    <th scope="row">个性签名</th>

                    <td >{{$userdatas->signature}}</td>

                </tr>


                <tr>

                    <th scope="row" height="200">个人简介</th>

                    <td height="200">{{$userdatas->brief_introduction}}</td>

                </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{--上面 一行 的 结束--}}


    {{--按钮 一行 的 开始 --}}

    <div class="row">

        <div class="col-md-4">

            <form id="form1" enctype="multipart/form-data">

                {{csrf_field()}}

                <input type="hidden" name="hide_mail" value="{{$userdatas->mail}}" />

                <input type="hidden" name="hide_id" value="{{session('user')->student_id}}" />

                <input type="submit" value="确认购买"><br/>

            </form>

        </div>

    </div>

    {{--按钮 一行 信息的 结束 --}}

@endsection

@section('script')

    <script>

        /*
        * 点击按钮 进行 ajax 异步传输 / 上传 数据 将 邮件 的 目的地 以及 购买者 学号 发送出去
        *
         */

$(document).ready(function(){

$("#form1").submit(function(){

    jQuery.noConflict();

    $.post(

        "{{url('admin/mail')}}",

        {

            hide_mail:$("input[name=hide_mail]").attr("value"),

            hide_id:$("input[name=hide_id]").attr("value"),

            cache: false,          //不可缺

            contentType: false,    //不可缺

            processData: false,    //不可缺

            '_token':'{{csrf_token()}}', //不可缺 身份保密验证

        },

        function (data) {

            if(data.status=='ok'){

                layer.msg('发送成功', {icon: 6});}  //使用 第三方的 js 代码 函数

        }       //callback function

        );

    return false;    //阻止 按钮(提交按钮) 进行的 本身的默认 路由 处理

});


});

    </script>

@stop