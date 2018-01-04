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

    /**
     * 分类目录
     * @param $id
     * @return
     */
    public function cate($id)
    {
        //分类目录
        $field = Category::find($id);

        //查看次数自增
        Category::where('cate_id',$id)->increment('cate_view');

        //查询当前分类的子分类
        $submenu = Category::where('cate_pid',$id)->get();

        // 图文列表前5篇（带分页）
        $data = Article::where('cate_id',$id)->orderBy('art_time','des')->paginate(4);

        return view('home.list',compact('field','data','submenu'));
    }

    /**
     * 文章
     * @param $id    文章id
     * @return
     */
    public function article($id)
    {
        //关联查询
        $data = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$id)->first();

        //查看次数自增
        Article::where('art_id',$id)->increment('art_view');

        //上一篇、下一篇
        $article['pre'] = Article::where('art_id','<',$id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$id)->orderBy('art_id','asc')->first();

        //相关文章
        $r_data = Article::where('cate_id',$data->cate_id)->orderBy('art_id','desc')->take(6)->get();

        return view('home.new',compact('data','article','r_data'));
    }
}
