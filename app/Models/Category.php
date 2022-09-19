<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //可批量赋值字段
    protected $fillable = ['name','pid','level','group'];
    /**
     * 分类的子类
    */
    public function children(){
        return $this->hasMany(Category::class,'pid','id');
    }
}
