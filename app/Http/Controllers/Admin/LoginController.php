<?php

namespace App\Http\Controllers\Admin;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;

class LoginController extends CommonController
{

    /**
     * 后台登录界面
     */
    public function login()
    {
        return view('admin.login');
    }


    /**
     * 验证码类
     * @return mixed    验证码
     */
    public function code()
    {
        $phrase = new PhraseBuilder();
        $code = $phrase->build(4);    //设置验证码的个数

        //实例化
        $builder = new CaptchaBuilder($code,$phrase);

        $builder->build(102,35);    //设置宽高

        \Session::set('phrase',$builder->getPhrase());    //存储验证码到session

        header('Cahce-Control:no-cache,must-revalidate');    //设置/浏览器不缓存

        //输出验证码
        return response($builder->output())->header('Content-type','image/jpeg');
    }
}
