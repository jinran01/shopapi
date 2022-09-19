<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;
    //可批量赋值字段
    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'description',
        'price' ,
        'stock',
        'cover',
        'is_on',
        'is_recommend',
        'pics',
        'detail'
    ];
    protected $casts=[
        'pics' => 'array'
    ];

    /**
     * 追加额外的属性
    */
    protected $appends = ['cover_url','pics_url'];
    /**
     * oss url
     */
    public function getCoverUrlAttribute(){
        return oss_url($this->cover);
    }
    /**
     *Pics oss url
     */
    public function getPicsUrlAttribute(){
        return collect($this->pics)->map(function ($itme){
            return oss_url($itme);
        });
    }
    /**
     * 商品所属的分类
    */
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    /**
     * 商品所属的用户
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 商品所属的评论
     */
    public function comments(){
        return $this->hasMany(Comment::class,'goods_id','id');
    }
}
