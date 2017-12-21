<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

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
}
