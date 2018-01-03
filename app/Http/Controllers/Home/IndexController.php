<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
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

        // 友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home.index',compact('hotArticle','data','newArticle','randomArticle','links'));
    }

    public function cate($id)
    {
        //分类目录
        $field = Category::find($id);

        //查询当前分类的子分类
        $submenu = Category::where('cate_pid',$id)->get();

        // 图文列表前5篇（带分页）
        $data = Article::where('cate_id',$id)->orderBy('art_time','des')->paginate(4);

        return view('home.list',compact('field','data','submenu'));
    }

    public function article()
    {
        return view('home.new');
    }
}
