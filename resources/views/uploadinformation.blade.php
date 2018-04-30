
@extends('common.NoLeft_SideNote_Layout')

@section('style')

    <style>

        #hhh1{

            padding-top:25px;

            padding-bottom:25px;

            padding-right:50px;

            padding-left:10px;
        }

        #hhh2{

            padding-top:25px;

            padding-bottom:25px;

            padding-right:50px;

            padding-left:50px;

        }

    </style>

@stop

@section('content')

    <form id="form1">

        {{csrf_field()}}



        <div class="row">

            <div class="col-2" style="padding-bottom: 25px">

                <div class="card" >

                    <div class="card-header text-center" id="ret_img">

                        <h4>Img</h4>

                    </div>

                    <div class="card-body">

                        <h4 class="card-title text-center">上传头像</h4>

                        <p class="card-text"> <input name="picture" type="file"/></p>

                        <a href="#" class="card-link"></a>

                    </div>

                </div>

            </div>

        </div>







        <div class="row">

            <div class="col-2">

                <div class="input-group mb-3">

                    <div class="input-group-prepend">

                        <span class="input-group-text" id="basic-addon1">用户名</span>

                    </div>

                    <input disabled="true" type="text" class="form-control" placeholder="username" aria-label="Username" aria-describedby="basic-addon1" name="username" value="{{$datas->user_name}}">

                </div>

            </div>

        </div>







        <div class="row">

            <div class="col-2">

                <div class="input-group mb-3">

                    <div class="input-group-prepend">

                        <span class="input-group-text" id="basic-addon1">性别</span>

                    </div>

                    <input disabled="true" type="text" class="form-control" placeholder="sex" aria-label="Username" aria-describedby="basic-addon1" name="sex" value="{{$datas->sex}}">

                </div>

            </div>

        </div>






        <div class="row">

            <div class="col-2">

                <div class="input-group mb-3">

                    <div class="input-group-prepend">

                        <span class="input-group-text" id="basic-addon1">校区</span>

                    </div>

                    <input disabled="true" type="text" class="form-control" placeholder="campus" aria-label="Username" aria-describedby="basic-addon1" name="campus" value="{{$datas->campus}}">

                </div>

            </div>

        </div>








        <div class="row">

            <div class="col-2">

                <div class="input-group mb-3">

                    <div class="input-group-prepend">

                        <span class="input-group-text" id="basic-addon1">手机号</span>

                    </div>

                    <input disabled="true" type="text" class="form-control" placeholder="phonenumber" aria-label="Username" aria-describedby="basic-addon1" name="phonenumber" value="{{$datas->phone_number}}">

                </div>

            </div>

        </div>







        <div class="row">

            <div class="col-2">

                <div class="input-group mb-3">

                    <div class="input-group-prepend">

                        <span class="input-group-text" id="basic-addon1">个性签名</span>

                    </div>

                    <input disabled="true" type="text" class="form-control" placeholder="signature" aria-label="Username" aria-describedby="basic-addon1" name="signature" value="{{$datas->signature}}">

                </div>

            </div>

        </div>





        <div class="row">

            <div class="col-4">

                <div class="input-group">

                    <div class="input-group-prepend">

                        <span class="input-group-text">自我介绍</span>

                    </div>

                    <textarea disabled="true" class="form-control" aria-label="With textarea" name="briefintroduction">{{$datas->brief_introduction}}</textarea>

                </div>

            </div>

        </div>






        {{--这一行中 有两个 按钮 一个是 占 两列 的提交 另一个 是 占两列 的修改--}}

        <div class="row">



            <div class="col-2" id="hhh2">

                <input type="button" value="提交" class="btn" disabled="true"/>

            </div>



            <div class="col-2" id="hhh1">

                <input type="button" value="修改" class="btn"/>

            </div>


        </div>

    </form>

@stop


@section('script')

    <script type="text/javascript">

        $('#hhh2 :input').click(function(){

            jQuery.noConflict();

            var formData = new FormData($('form')[0]);

            $.ajax({

                url:'{{url('admin/uploadinformation')}}',

                type:'POST',

                data:formData,

                cache: false,  //不可缺

                contentType: false,    //不可缺

                processData: false,//不可缺

                '_token':'{{csrf_token()}}',

                success:function(data){

                    /*
                    *这是 用户没有上传 头像 产生的 回传 的数据
                     */

                   if(data.path=='nophoto'){

                       layer.msg('上传成功', {icon: 6});

                       return;

                   }

                   /*
                   *这是 用户 上传 后 头像 的 回传过来的 数据 ，主要是 为了 回显 头像
                   *
                    */

                    var img =$("<img src='"+data.path+"' alt='' class=\"card-img-top\"/>");

                    $("#ret_img").replaceWith(img);

                    layer.msg('上传成功', {icon: 6});

                }

            });

        });



            $("#hhh1 :input").click(function(){

            $("#hhh2 :input").attr("disabled",false);

            $("#form1 :disabled").attr("disabled",false);

        });



    </script>


@stop