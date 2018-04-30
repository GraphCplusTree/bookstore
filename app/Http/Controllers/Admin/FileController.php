<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\book;
use App\Http\Model\student;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon;

class FileController extends Controller
{

    public function upload(Request $request){


        /*
         *针对此例 ，判断请求 类型 type 是否是 post
         */

            if ($request->isMethod('post')) {

                /*
                 *
                 * 利用 laravel 中 的request 对象 的实例 中的 一些 方法 得到 文件的 对象实例 引用
                 */

            $file = $request->file('picture');

            // 文件是否上传成功

                if ($file->isValid()) {

                // 获取文件相关信息

                    //$original= $file->getClientOriginalName(); // 得到文件原名 在本例 中实质上 作用不大

                    $ext = $file->getClientOriginalExtension();     // 得到扩展名 需要用到

                    $realPath = $file->getRealPath();   //临时文件的绝对路径 上传动 服务器上的 暂时存储的 地方

                    //$type = $file->getClientMimeType();     // image/jpeg  图像 文件类型 本例 没用


                    // 开始 上传文件

                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext; //给文件 重命名 注意 uniqid() 方法 是生成一个 唯一的 ID

                    // 使用我们新建的uploads本地存储空间（目录）在 config/filesystems.php文件中 配置 本地服务器驱动

                    $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));  //put 方法中 第一个 参数 是 新的文件名字
                                                                                                    //第二个 参数 是一个 字符串 其中的 函数 返回一个 字符串 ，这个函数 从一个暂存 的文件的绝对路径 将 文件 读取到 一个 字符串中 并返回一个 字符串




                    /*
                     * 将用户 上传的 相关信息 填写到 数据库中
                     *
                     */

                    $book_datas=new book;


                    $book_datas->book_belongto=session('user')->student_id;

                    $book_datas->book_category=$request->input('characters');

                    $book_datas->book_name=$request->input('bookname');

                    $book_datas->book_author=$request->input('bookauthor');

                    $book_datas->publishing_house=$request->input('publinghouse');

                    $book_datas->price=$request->input('price');

                    $book_datas->book_introduction=$request->input('bookintroduction');

                    $book_datas->book_photo=asset('uploads/'.$filename);  //此时 数据库中 保存 照片 的 方式 是使用 图片 路径 的方式

                    $book_datas->book_institute_belong=$request->input('institute');

                    $book_datas->save();

                     $data=[

                         'path'=>asset('uploads/'.$filename),

                         ];   //回传数据中  注意 回传 图片 在服务器上的 存储路径

                     return $data;

                }

            }

        }



        public function uploadview(){


        $infor=student::Where('student_id','=',session('user')->student_id)->first();


        $user_name=$infor->user_name;


        return view('book_uploadview',compact("user_name"));


    }




    public function uploadinformationview(){

    $datas=student::where('student_id','=',(session("user")->student_id))->first();

    return view('uploadinformation',compact("datas"));

    }




    public function uploadinformation(Request $request){

        if ($request->isMethod('post')) {


            /*
             * laravel 中 ORM 模型 中更新 数据 记录 的方法
             *
             * 先使用 find(主键)  找到  对应的   模型对象记录
             *
             * 然后 使用 正常的 对象赋值 的方式 进行 更新
             *
             * 使用 save()方法 进行更新
             */


              $student_datas=student::find(session('user')->student_id);

              $student_datas->user_name=$request->input("username");

              $student_datas->phone_number=$request->input("phonenumber");

              $student_datas->sex=$request->input("sex");

              $student_datas->campus=$request->input("campus");

              $student_datas->brief_introduction=$request->input("briefintroduction");

              $student_datas->signature=$request->input("signature");

            // 文件是否上传成功

            if ($file = $request->file('picture')) {

                if($file->isValid()) {

                    // 获取文件相关信息

                    //$original= $file->getClientOriginalName(); // 文件原名

                    $ext = $file->getClientOriginalExtension();     // 扩展名

                    $realPath = $file->getRealPath();   //临时文件的绝对路径

                    //$type = $file->getClientMimeType();     // image/jpeg


                    // 上传文件

                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;

                    // 使用我们新建的uploads本地存储空间（目录）

                    $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));

                    $student_datas->profile_photo = asset('uploads/' . $filename);

                    $student_datas->save();

                    $data = [

                        'path' => asset('uploads/' . $filename),

                    ];

                    return $data;

                }

            }


            /*
             * 上面 的 if 判断语句 是为了 防止 用户 如果没有上传 （不想上传 自己的 头像）而进行 的
             *
             * 措施
             *
             */




           $student_datas->save();

            $data=[

                'path'=>'nophoto'

            ];

       return $data;

        }

    }


    /*
     *
     *发送 邮件 的相关 处理逻辑
     */


    public function buyaction(Request $request){



        $mail_address=$request->input("hide_mail");

        $hide_id=$request->input("hide_id");

        $message_sent=['email'=>$mail_address,'id'=>$hide_id];

        /*
        *
        *存储到 队列的 时候 延迟发送 的事时间配置  可以查看laravel 官方文档
        *
        */

        $when = Carbon\Carbon::now()->addMinutes(1/6);

        //发送 邮件 的 格式 ，注意 实例化的 时候 需要将 购买者 学号传输进去 因为构造函数带 一个参数

        Mail::to($message_sent['email'])->later($when,new OrderShipped($message_sent['id']));

        return ['status'=>'ok'];
    }

}
