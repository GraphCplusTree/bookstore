@extends('common.NoLeft_SideNote_Layout')

@section('namefetch')

    <h5>{{$user_name}}</h5>

@stop

@section('style')

    <style>

        {{--增加组件 的内边距--}}

        #hhh1{

            padding-top:25px;

            padding-bottom:25px;

            padding-right:50px;

            padding-left:50px;

        }

        #hhh2{

        padding-top:25px;

        padding-bottom:25px;

        padding-right:50px;

        padding-left:50px;

    }

        #hhh3{

        padding-top:25px;

        padding-bottom:10px;

        padding-right:50px;

        padding-left:50px;

        }

    </style>

    @stop

@section('content')

<form>

    {{--laravel 框架 要求 传输表单数据的 时候 表单中 需要 有一个 csrf 的类似的 安全的 域--}}

    {{csrf_field()}}

    <div class="row">

        <div class="col-2" id="hhh3">

            <select class="form-control" name="institute">

                <option value="economy">经济学院</option>

                <option value="law">法学院</option>

            </select>

        </div>

    </div>



    <div class="row">

        <div class="col-2" id="hhh1">

            <select class="form-control" name="characters">

                <option value="demand">求书</option>

                <option value="sale">售书</option>

            </select>

        </div>

    </div>



    <div class="row">
        <div class="col-2" style="padding-bottom: 25px">

            <div class="card" >

                    <div class="card-header text-center" id="ret_img">

                        <h4>Book</h4>

                    </div>

                <div class="card-body">

                    <h4 class="card-title text-center">Your  img</h4>

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

                    <span class="input-group-text" id="basic-addon1">书名</span>

                </div>

                <input type="text" class="form-control" placeholder="bookname" aria-label="Username" aria-describedby="basic-addon1" name="bookname">

            </div>

        </div>

    </div>





    <div class="row">

        <div class="col-2">

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <span class="input-group-text" id="basic-addon1">作者</span>

                </div>

                <input type="text" class="form-control" placeholder="bookauthor" aria-label="Username" aria-describedby="basic-addon1" name="bookauthor">

            </div>

        </div>

    </div>






    <div class="row">

        <div class="col-2">

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <span class="input-group-text" id="basic-addon1">出版社</span>

                </div>

                <input type="text" class="form-control" placeholder="publishinghouse" aria-label="Username" aria-describedby="basic-addon1" name="publinghouse">

            </div>

        </div>

    </div>








    <div class="row">

        <div class="col-2">

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <span class="input-group-text" id="basic-addon1">价格</span>

                </div>

                <input type="text" class="form-control" placeholder="price" aria-label="Username" aria-describedby="basic-addon1" name="price">

            </div>

        </div>

    </div>





    <div class="row">

        <div class="col-4">


            <div class="input-group">

                <div class="input-group-prepend">

                    <span class="input-group-text">书籍简介</span>

                </div>

                <textarea class="form-control" aria-label="With textarea" name="bookintroduction"></textarea>

            </div>

        </div>

    </div>





    <div class="row">

        <div class="col-2" id="hhh2">

            <input type="button" value="Upload" class="btn" />

        </div>

    </div>

</form>

@stop

@section('script')


    <script type="text/javascript">

    $(':button').click(function(){

        jQuery.noConflict();

        var formData = new FormData($('form')[0]);

        $.ajax({

            url:'{{url('admin/upload')}}',

            type:'POST',

            data:formData,

            cache: false,       //不可缺

            contentType: false,  //不可缺

            processData: false,//不可缺

            '_token':'{{csrf_token()}}',

            success:function(data){  //成功接收后 的callback function

                var img =$("<img src='"+data.path+"' alt='' class=\"card-img-top\"/>");

                $("#ret_img").replaceWith(img);

                layer.msg('上传成功', {icon: 6});

            },

        });

    });
</script>


@stop