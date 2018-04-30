<?php
namespace App\Http\Controllers;

use App\Http\Model\student;
use App\Http\Model\testuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/*
 * 登陆注册时候需要用到的
 *
 * 登陆控制器
 *
 * 注册控制器
 */



class LoginController extends Controller
{

    public function login()
    {
        /*
         * 判断用户发送过来的请求中所带的表单中信息是否为空
         *
         * laravel中取出对应表单中标记名 在这里是用Input大类
         *
         * 并且是用Input::中的一些取出标记名的方法
         *
         */

        if ($input=Input::all()) {

            $username=$input['name'];

            /*
             * first()方法取出来一个数据库中的一条记录
             */

            $ret_id=student::where('student_id','=',$username)->first();


            if($ret_id) {

                if ($ret_id->student_id == $input['name'] && $ret_id->password == $input['password']) {

                    /*
                     * 使用数组的方式将用户的学号和密码保存到 session会话中
                     */
                    session(['user' => $ret_id]);

                    /*
                     * 重定向到主页中
                     */
                    return redirect('admin/home');
    }

    /*
     * 当取出来的$ret_id中的 id信息 和 密码信息 的时候和 用户请求中的ID 和 密码 不一致的时候
     */

    else {

                    /*
                     * back()方法重新退回到上一页（也就是登陆页）
                     * 你可以使用连接with()方法传递key value 到登陆页面
                     */
                    return back()->with('msg', '用户名或者密码错误');

                }
}

/*
 * 当根据用户请求中的id 和 password 从数据库中select的时候 没有匹配的的数据
 */
    else{

    return back()->with('msg', '用户名或者密码错误');
}

        }
        /*
         *用户的请求根本没有表单数据即 Input::all()为空
         *
         * 比如说 用户只是要访问 登陆界面！
         *
         */
        else {
            return view('login');
        }
    }

    /*
     * 控制器中的注册的方法
     */

    public function signup(Request $request){

        /*
         *laravel中ORM 中生成一个数据库中对应的表 的模型实例
         *
         * 通过方法中的参数 中内置的 Request 类的一个实例， 并且利用其中的方法 input() 获取用户填入的表单内容
         *
         * 保存到数据库
         */



        $student=new student;


        $student->student_id=$request->input('name');

        $student->password=$request->input('password');

        $student->save();


        return redirect('/');  //  只是访问 登录 界面 因此 根据上述方法 回跳转到 最后一个 else {return view('login')}



    }



}

