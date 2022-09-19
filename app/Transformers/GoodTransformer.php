<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Good;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class GoodTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category','user','comments'];

    public function transform(Good $good){
        $pics_url = array();
        foreach ($good->pics as $p){
            array_push($pics_url,oss_url($p));
        }
        return [
            'id' => $good->id,
            'title' => $good->title,
            'category_id' => $good->category_id,
//            'category_name' => Category::find($good->category_id)->name,
            'description' => $good->description,
            'price' => $good->price,
            'stock' => $good->stock,
            'cover' => $good->cover,
            'cover_url' => oss_url($good->cover),
            'pics' => $good->pics,
            'pics_url' => $pics_url,
            'detail' => $good->detail,
            'is_on' => $good->is_on,
            'is_recommend' => $good->is_recommend,
            'created_at' => $good->created_at,
            'updated_at' => $good->updated_at,
        ];
    }

    /**
     * 额外的分类数据
    */
    public function includeCategory(Good $good){

        return $this->item($good->category,new CategoryTransformer());
    }

    /**
     * 额外的用户数据
     */
    public function includeUser(Good $good){

        return $this->item($good->user,new UserTransformer());
    }

    /**
     * 额外的评价数据
     */
    public function includeComments(Good $good){

        return $this->collection($good->comments,new CommentTransformer());
    }
}
