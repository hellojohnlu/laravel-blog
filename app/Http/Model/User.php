<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';  // 设置数据库表
    protected $primaryKey = 'user_id';  // 设置主键 id
    public $timestamps = false;
}