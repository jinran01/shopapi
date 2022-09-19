<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    //可批量赋值字段
    protected $fillable = ['user_id','goods_id','num'];
    /**
     * 所关联的商品
    */
    public function goods(){
        return $this->belongsTo(Good::class,'goods_id','id');
    }
}
