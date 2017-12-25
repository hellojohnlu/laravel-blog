<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::match(['get', 'post'],'login','LoginController@login');    //后台登录
    Route::get('code','LoginController@code');      //验证码
});

Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index','IndexController@index');    //后台首页
    Route::get('info','IndexController@info');      //后台首页主体内容
    Route::get('quit','LoginController@quit');      //退出登录
    Route::match(['get','post'],'editpass','IndexController@editPassword'); //修改密码
    Route::get('jump','CommonController@jump');     //页面跳转

    Route::resource('category','CategoryController');   //文章分类
    Route::post('cate/changeOrder','CategoryController@changeOrder');   //分类排序

    Route::resource('article','ArticleController');     //文章
//    Route::match(['get','post'],'upload','CommonController@upload');         //图片上传
    Route::any('upload','FileController@upload');         //图片上传
});

