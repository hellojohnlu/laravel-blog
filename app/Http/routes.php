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

    Route::get('admin/index','Admin\IndexController@index');    //后台首页
    Route::get('admin/info','Admin\IndexController@info');    //后台首页
});