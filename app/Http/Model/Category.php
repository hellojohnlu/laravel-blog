<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;

    /**
     * 多级分类目录树
     *
     * @return array
     */
    public function tree()
    {
        $categories = $this->all();  //获取数据表数据
        $data = $this->getTree($categories, 'cate_name','cate_id','cate_pid');    //多级分类
        return $data;
    }

    /**
     * 实现多级分类
     */
    public function getTree($data,$field_name,$field_id = 'id',$field_pid = 'pid',$pid = 0)
    {
        $arr = [];
        foreach ($data as $k => $v) {
            // 读取一级分类
            if ($v->$field_pid == $pid) {
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];

                foreach ($data as $m => $n) {
                    // 父级分类下的子分类
                    if ($n->$field_pid == $v->$field_id) {
                        $data[$m]["_".$field_name] = '|—— '.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
