<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends CommonController
{
    public function index ()
    {
        // 点击量最高的6篇文章
        $hotArticle = Article::orderBy('art_view','des')->take(6)->get();

        // 图文列表前5篇（带分页）
        $data = Article::orderBy('art_time','des')->paginate(5);

        // 最新文章
        $newArticle = Article::orderBy('art_view','des')->take(8)->get();

        // 随机文章
        $randomArticle = Article::orderBy('art_id','des')->get()->random(5);

        // 友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home.index',compact('hotArticle','data','newArticle','randomArticle','links'));
    }

    public function cate()
    {
        return view('home.list');
    }

    public function article()
    {
        return view('home.new');
    }
}
