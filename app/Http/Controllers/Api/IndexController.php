<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;

use App\Models\Good;
use App\Models\Slides;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

    //首页数据
    public function index(){

        //轮播图数据
        $slides = Slides::where('status',1)
            ->orderBy('seq')
            ->get();
        //分类数据
        $categories = cache_category();
        //推荐商品数据
        $goods = Good::where('is_on',1)
            ->where('is_recommend',1)
            ->get();
        return $this->response->array([
           'slides' => $slides,
           'categories' => $categories,
            'goods' => $goods,
        ]);
    }
}
