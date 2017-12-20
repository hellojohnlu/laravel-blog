<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;

class LoginController extends CommonController
{

    /**
     * 后台登录界面
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            //获取表单数据
            $input = $request->all();

            // 校验验证码
            if ($input['code'] !== $this->getCode()) {
                return back()->with('msg','验证码错误'); //返回session提示信息
            }

            $user = User::first();  // 获取 user 表数据
            // 校验用户名与密码
            if ($input['username'] != $user->username || $input['password'] != Crypt::decrypt($user->password)) {
                return back()->with('msg','用户名或密码错误');
            }

            session(['user'=>$user['username']]);  // 如果登录成功，存入 session

            return redirect('admin/index'); // 跳转到后台首页
        }else{
            return view('admin.login');
        }
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

        header('Cache-Control:no-cache,must-revalidate');    //设置/浏览器不缓存

        //输出验证码
        return response($builder->output())->header('Content-type','image/jpeg');
    }

    private function getCode(){
        return session('phrase');
    }

    public function crypt()
    {

    }
}