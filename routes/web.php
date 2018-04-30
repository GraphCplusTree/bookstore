<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*
 * 无须身份验证的路由
 * 登陆的路由
 * 注册的路由
 *
 */



Route::group(['middleware' => 'web'], function () {

      Route::any('/','LoginController@login');
      Route::any('signup','LoginController@signup');

});




Route::group(['middleware' => ['web','admin.login',],'namespace'=>'Admin','prefix'=>'admin'], function () {

    /*
     * 关于 home 页 中的 相关的 路由
     */

      Route::any('home','HomeController@home');

      Route::any('demand','HomeController@demand');

      Route::any('quit','HomeController@quit');

      Route::any('select/{title}/left/{lefttitle}','HomeController@skip_page');

      Route::any('chat','HomeController@chat');

      Route::any('action/{bookid}/bookbelong/{studentid}','HomeController@detailed');





    /*
    *和 上传 文件 或者 个人 信息有关的 路由
    */

      Route::any('uploadview','FileController@uploadview');  //上传 界面 的返回

      Route::any('upload','FileController@upload');  //上传 控制器逻辑处理

      Route::any('uploadinformation','FileController@uploadinformation');

      Route::any('uploadinformationview','FileController@uploadinformationview');

      Route::any('mail','FileController@buyaction'); // 上传 邮件 处理


});




