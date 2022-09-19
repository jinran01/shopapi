<?php

namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    //
    protected $availableIncludes = ['user','goods'];
    public function transform(Comment $comment){

        $pics_url = array();
        if (in_array($comment->pics)){
            foreach ($comment->pics as $p){
                array_push($pics_url,oss_url($p));
            }
        }
        return [
            'id'=>$comment->id,
            'user_id'=>$comment->user_id,
            'goods_id'=>$comment->goods_id,
            'content'=>$comment->content,
            'pics' => $comment->pics,
            'pics_url' => $pics_url,
            'rate'=>$comment->rate,
            'reply' => $comment->reply,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,

        ];
    }
    /**
     * 额外用户数据
    */
    public function includeUser(Comment $comment){
        return $this->item($comment->user,new UserTransformer());
    }

    /**
     * 额外商品数据
     */
    public function includeGoods(Comment $comment){
        return $this->item($comment->goods,new GoodTransformer());
    }
}
