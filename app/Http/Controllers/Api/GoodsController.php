<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;

use App\Models\Good;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     */
    public function index(Request $request){

        //搜索条件
        $title = $request->query('title');
        $category_id = $request->query('category');

        //排序
        $sales = $request->query('sales');
        $price = $request->query('price');
        $comments_count = $request->query('comments_count');

        //商品分页数据
        $goods = Good::select('id','title','price','cover','category_id','sales')
            ->where('is_on',1)
            ->when($title,function ($query) use ($title){
                $query->where('title','like',"%{$title}%");
            })
            ->when($category_id,function ($query) use ($category_id){
                $query->where('category_id',$category_id);
            })
            ->when($sales == 1,function ($query) use ($sales){
                $query->orderBy('sales','desc');
            })
            ->when($price == 1,function ($query) use ($price){
                $query->orderBy('price','desc');
            })
            ->withCount('comments')
            ->when($comments_count == 1,function ($query) use ($comments_count){
                $query->orderBy('comments_count','desc');
            })
            ->orderBy('updated_at','desc')
            ->paginate(20)
            ->appends([
                'title' => $title,
                'category_id' => $category_id,
                'sales' => $sales,
                'price' => $price,
                'comments_count' => $comments_count,

            ]);
        //推荐商品
        $recommend_goods = Good::select('id','title','price','cover')
            ->where('is_on',1)
            ->where('is_recommend',1)
            ->withCount('comments')
            ->inRandomOrder()
            ->take(10)
            ->get();

        //分类数据
        $categories = cache_category();

        return $this->response->array([
            'goods' => $goods,
           'recommend_goods' =>$recommend_goods,
           'categories' => $categories,
        ]);
    }

    /**
     * 商品详情
    */
    public function show($id){
        //商品详情
        $good = Good::where('id',$id)
            ->with([
                'comments.user' => function ($query) {
                    $query->select('id','name','avatar');
                }
            ])
            ->first();
        //相关商品
        $like_goods = Good::where('is_on',1)
            ->select('id','title','price','cover','sales')
            ->where('category_id',$good->category_id)
            ->inRandomOrder()
            ->take(10)
            ->get()
            ->makeHidden('pics_url');
//            ->transform(function ($item){
//                return $item->setHidden(['pics_url']);
//            });

        //返回数据
        return $this->response->array([
           'good' => $good,
            'like_good' => $like_goods,
        ]);
    }
}
