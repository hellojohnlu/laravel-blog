<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class IndexController extends CommonController
{
    public function index()
    {
        return '后台首页';
    }
}
