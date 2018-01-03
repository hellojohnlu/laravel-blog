<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $navs = Navs::all();    //获取导航菜单数据

        // 最新文章
        $newArticle = Article::orderBy('art_time','des')->take(8)->get();
        // 随机文章
        $randomArticle = Article::orderBy('art_id','des')->get()->random(5);

        View::share(['navs'=>$navs,'newArticle'=>$newArticle,'randomArticle'=>$randomArticle]);  //共享参数，因多个模板都需调用$navs
    }
}
