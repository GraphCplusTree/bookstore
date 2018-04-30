<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

/*
 * 邮件 中的 相关数据 自定义
 */

    public $datas;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datas)
    {
        // 将 实例化 后的对象中的 相关属性 赋值 ，因为 传输 邮件 使用的 模版引擎 中的 数值 是通过 实例化 后的 对象的 相关 属性 传递的

        $this->datas=$datas;

    }

    /**
     * Build the message.
     *
     * @return $this
     */

    /*
     * 此build()方法 是需要发送邮件的时候 自动 调用的
     */

    public function build(){

        return $this->view('emails');

    }

}
