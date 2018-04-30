<?php

namespace App\Console\Commands;

use App\Http\Model\comments;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\Constraint\SameSize;

/*
 * 自定义 laravel 命令,使得swoole配合laravel
 */


class swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /*
     *
     * 在 swoole 类中 需要 有一个 标签 注册 到 php artisan 命令中 其中 大括号{  } 的作用 是 在你 使用 php artisan 命令 的时候 需要 传递进去一个参数
     *
     * 参数 是传递给 后面 的 成员方法  handle() 中的 argument(key) 的
     */


    protected $signature = 'swoole:action {action}';

    /**
     * The console command description.
     *
     * @var string
     */

    /*
     * php artisan 自定义命令中 需要 强制写一个 命令的 描述符
     *
     *
     */
    protected $description = 'swoole command';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /*
     * 构造函数
     */
    public function __construct()
    {

        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $action=$this->argument('action');

       /*
        *行为 判断
        */

       switch($action){

                case "start":

                        $this->start();

                        break;

                  case "stop":

                        $this->stop();

                        break;
                 case "restart" :

                        $this->restart();

                         break;


             }

      }


    private function start(){

        /*
         * 在这里 均使用 的 原生 的 php 扩展中 的 redis 以及 swoole 扩展
         *
         * 注意 从 根目录 下面 开始查找 加上 一个 \
         *
         */


        /*
         * redis 对象 实例化
         *
         */


        $redis = new \Redis();

        $redis->connect('127.0.0.1',6379);


        /*
         *
         *swoole  websocket 对象 实例化
         */

        $ws=new \swoole_websocket_server('127.0.0.1',9502);



        /*
         * 即时 在线 传输 信息 websocket 开始
         *
         *
         * 注意 在 swoole 中 的 redis 对象 貌似 作用域 访问不到 因此 在 function 中 使用 use($redis) 进行 函数内部访问
         */


        /*
         * websocket 连接 开始的时候
         *
         */

        $ws->on('open', function ($ws, $request)use($redis) {

            /*
             * 设置用户ID
             *
             * 并 存入数据库中 缓存中 redis 集合 表示名 为： fd
             */

            $redis->sAdd('fd',$request->fd);

            //如果 不 设置为 后台执行 ，相关信息 会输出到 控制台

            echo "server: handshake success with fd{$request->fd}\n";

        });



        /*
         * 连接 正式开始
         *
         * 开始传输信息 执行的 逻辑 这里的 $frame 包含着 客户端 的所有 相关 信息
         *
         */

        $ws->on('message', function ($ws, $frame)use($redis){

            $data=new comments;

            $student_messages=$frame->data;

            /*
             * 解析 字符串 使用： 使用 类似 正则 的方式 分割字符串
             *
             * 保存到一个数组中
             */

            $chat_expolde=explode(":",$student_messages);

            //若 非 后台执行 那么 输出到 控制终端
            var_dump($student_messages);


            /*
             * 保存到 真正的 数据库 中
             */

            $data->chat_student_id=$chat_expolde[0];

            $data->chat_student_messages=$chat_expolde[1];

            /*
             * 注意设置 中国 地区的 对应的 区时 这样 以后 用的 data() 函数 就比较 ok 啦
             */

            date_default_timezone_set('PRC');

            /*
             * 注意 php 中的 函数中 的date(你需要格式化的 格式，时间戳)
             */

            $data->time=date('Y-m-d H:i:s',time());

            $data->save();


            /*
             *从 redis 缓存中 取出 集合中 的所有 客户端的 标符
             */

            $fds=$redis->sMembers('fd');


            /*
             * 以 JSON 格式 返回  将 关联数组 转化为 JSON 对象（格式）
             *
             */

             $msg=json_encode([

                 'student_messages'=>$student_messages

             ]);

             /*
              * 迭代器 遍历 集合中 的每一个元素 （客户端 标识符）
              *
              */

             foreach ($fds as $fd){

                 /*
                  * 主动 向 客户端 推送信息
                  *
                  */

                 $ws->push($fd,$msg);

             }


        });

        $ws->on('close',function($ws,$fd)use($redis){

            /*
             * 每次 用户 关闭一个 websocket (tcp) 连接 的时候 ，从缓存中 redis  中 将 fd集合中 的相关 客户端  标识符 除掉
             *
             */

            $redis->sRem('fd',$fd);

        });


        /*
         * websocket 服务器 启动
         *
         */


        $ws->start();

    }


    private function stop(){



    }



    private function restart(){




    }





}
