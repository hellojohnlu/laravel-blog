<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /**
     * 页面跳转方法
     */
    protected function jump(Request $request)
    {
        // 判断请求方式
        if (!$request->isMethod('get')) {
            return redirect('/');
        }

        // 验证参数
        if (!empty(session('message')) && !empty(session('url')) && !empty(session('jumpTime'))) {
            $data = [
                'message'       =>  session('message'),
                'url'           =>  session('url'),
                'jumpTime'      =>  session('jumpTime'),
                'status'        =>  session('status')
            ];
        }else{
            return redirect('/');
        }

        return view('admin.jump',['data'=>$data]);
    }
}
