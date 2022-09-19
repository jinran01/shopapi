<?php

namespace App\Transformers;

use App\Models\Order;

use App\Models\OrderDetails;
use League\Fractal\TransformerAbstract;

class OrderDetailsTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['goods','order'];
    public function transform(OrderDetails $orderDetails){
        return [
            'id'=>$orderDetails->id,
            'order_id'=>$orderDetails->order_id,
            'goods_id'=>$orderDetails->goods_id,
            'num' => $orderDetails->num,
            'created_at' => $orderDetails->created_at,
            'updated_at' => $orderDetails->updated_at,

        ];
    }

    /**
     * 额外的商品数据
    */
    public function includeGoods(OrderDetails $orderDetails){
        return $this->item($orderDetails->goods,new GoodTransformer());
    }

}
