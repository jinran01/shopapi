<?php

namespace App\Transformers;

use App\Models\Cart;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    //额外的引入的属性
    protected $availableIncludes = ['goods'];

    public function transform(Cart $cart){
        return [
            'id'=>$cart->id,
            'user_id'=>$cart->user_id,
            'goods_id'=>$cart->goods_id,
            'num' => $cart->num,
            'is_checked' => $cart->is_checked,
        ];
    }

    /**
     * 额外的商品数据
    */
    public function includeGoods(Cart $cart){
        return $this->item($cart->goods,new GoodTransformer());
    }

}
