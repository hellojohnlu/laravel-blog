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

Route::group([''], function () {
    Route::match(['get', 'post'],'admin/login','Admin\LoginController@login');    //后台登录
    Route::get('admin/code','Admin\LoginController@code');      //验证码
});

Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index','IndexController@index');    //后台首页
    Route::get('info','IndexController@info');      //后台首页主体内容
    Route::get('quit','LoginController@quit');      //退出登录
});