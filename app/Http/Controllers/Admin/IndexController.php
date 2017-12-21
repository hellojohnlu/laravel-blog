<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    /**
     * 后台首页
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * 后台主容主体
     */
    public function info()
    {
        return view('admin.info');
    }

    /**
     * 修改管理员密码
     */
    public function editPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();   //获取表单数据

            // 定义验证规则
            $rules = [
                'password_o'    =>  'required',
                'password'      =>  'required|min:6|confirmed',
            ];

            // 提示信息
            $messages = [
                'password_o.required'   =>  '请填写原始密码',
                'password.required'     =>  '新密码不能为空',
                'password.min'          =>  '新密码不能小于 6 位',
                'password.confirmed'    =>  '确认密码不一致',
            ];

            $validator = Validator::make($input, $rules, $messages);    //调用验证器

            if ($validator->passes()) {
                $user = User::first();  //获取user表数据
                $depassword = Crypt::decrypt($user->password);  //解密原密码

                // 如果原密码输入正确，则允许修改密码
                if ($input['password_o'] === $depassword) {
                    $user->password = Crypt::encrypt($input['password']);
                    if ($user->update()){
                        return redirect('admin/jump')->with(['message'=>'修改密码成功！','url' =>'info', 'jumpTime'=>3,'status'=>true]);
                    }else{
                        return back()->with(['errors'=>'修改密码失败，请重试！']);
                    }
                }else{
                    return back()->with(['errors'=>'原密码错误！']);
                }
            }else{
//                dd($validator->errors()->all());    //打印错误信息
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }
    }
}
