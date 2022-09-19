<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    //不允许批量赋值的字段
    protected $guarded = [];
    /**
     * 强制转换类型
     */
    protected $casts=[
      'pics' => 'array'
    ];
    /**
     * 评论所属用户
    */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 评论所属商品
     */
    public function goods(){
        return $this->belongsTo(Good::class,'goods_id','id');
    }
}
