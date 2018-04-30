<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         * 在用户请求的同时路由不会直接交给控制器进行逻辑处理，如果会话存在，将请求向下传递，即交给控制器
         *
         * 代码中看是否session中的变量是否为空
         */

          if(session('user')){


              return $next($request);
        }

        else{

              return redirect('/');

          }

    }

}
