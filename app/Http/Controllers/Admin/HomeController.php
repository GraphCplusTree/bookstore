<?php
/**
 * Created by PhpStorm.
 * User: wangdekun
 * Date: 2018/3/14
 * Time: 下午12:45
 */
namespace App\Http\Controllers\Admin;
use App\Http\Model\book;
use App\Http\Model\comments;
use App\Http\Model\student;
use App\HTTP\Model\testchat;
use App\Http\Model\testuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class HomeController extends CommonController{

   public function home(){

       /*
        * 第一次请求 admin/home 的时候，默认的情况 书籍分类区是：'sale'出售区 并且 是 economy 经济类的 书籍(注意：此时的home 路由也可以说是 售书区的默认页面)
        *
        * 从 book 表中 得到 以数组的方式组合 where 子句的过滤条件
        *
        * 并使用->get()方法 得到一个对象集合
        *
        * 与 first()方法 不太一样， first 由于 其 唯一性 laravel 直接给出了 的那条 记录 对应的 "对象"
        */

       $datas=book::where(['book_category'=>'sale','book_institute_belong'=>'economy'])->get();

       $newdatas=[];  //定义一个数组

       foreach ($datas as $data){

           $newdatas[]=$data;  //  压入数组

       }

       $infor=student::Where('student_id','=',session('user')->student_id)->first();

       $user_name=$infor->user_name;

       $title_category="sale";

       /*
        *传入模版引擎中 的 一些相关的 参数 key-value ,以便在 blade模版引擎中 引用
        *
        */

        return view('home',compact("newdatas","title_category","user_name"));

        }


/*
 * 求书区  的默  认页面 demand
 *
 *
 */

    public function demand(){

        $datas=book::where(['book_category'=>'demand','book_institute_belong'=>'economy'])->get();

        $newdatas=[];

        foreach ($datas as $data){

            $newdatas[]=$data;

        }

        $infor=student::Where('student_id','=',session('user')->student_id)->first();

        $user_name=$infor->user_name;

        $title_category="demand";

        return view('home',compact("newdatas","title_category","user_name"));
    }




/*
 * 登出 页面 路由对应的 控制器 将 session 中 对应的 键值 赋值 为null
 */

    public function quit(){

        session(['user'=>null]);

        return  redirect('/');

}



    /*
    *你点击 侧栏 的时候 每一个 带有 两个可选参数的 路由 所对应的 控制器
    *
    */

    public function skip_page(Request $request,$arg1,$arg2){

        $datas = book::where(['book_category' => $arg1, 'book_institute_belong' => $arg2])->get();

        $newdatas = [];

        foreach ($datas as $data) {

            $newdatas[] = $data;

        }

        $infor=student::Where('student_id','=',session('user')->student_id)->first();

        $user_name=$infor->user_name;

        /*
         * 注意： 需要将 传过来的 对应的 sale 或者 demand 参数再次 进行 判断 再次进行传输过去  重新进行一次 Blade 模版引擎的 重新填写
         */

        if($arg1=="sale") {

            $title_category = "sale";

            return view('home', compact("newdatas", "title_category","user_name"));

        }

        else if($arg1=="demand"){

            $title_category = "demand";

            return view('home', compact("newdatas", "title_category","user_name"));

        }


    }

    /*
    *  对于 用户页面 ajax 的异步请求 过来的 路由 进行 相应的 控制器的 处理
    *
    *
    */

    public function chat(Request $request){

        if($request->input('act')=="updatemsg") {

        $newchats = [];

        $time=$request->input('time');

        // 取出 comments 表中的 相关数据 对象 集合

        $datas =comments::where('time', '>', $time)->get();

        //如果没有取出 相关内容 ，判断 集合 是否为空的 方法 $datas->isEmpty()

        if($datas->isEmpty()){

            return ;

        }

        foreach ($datas as $data) {

            $newchats[] = $data;

        }

        return

            $newchats;   //自动 以 JSON 格式 的数据 方式 进行传输
    }

}

/*
 *
 * 根据 用户 点击的 带有 用户 详细信息 的 路由 而 转到 的 控制器
 *
 */

public function detailed(Request $request,$arg1,$arg2){

    $bookdatas=book::where('book_id','=',$arg1)->first();

    $userdatas=student::where('student_id','=',$arg2)->first();

    $infor=student::Where('student_id','=',session('user')->student_id)->first();

    $user_name=$infor->user_name;

    return view('detailed_information',compact("bookdatas","userdatas","user_name"));

}

}
