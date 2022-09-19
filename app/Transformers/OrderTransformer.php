<?php

namespace App\Transformers;

use App\Models\Order;

use App\Models\OrderDetails;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user','orderDetails','goods'];
    public function transform(Order $order){
        return [
            'id'=>$order->id,
            'order_no'=>$order->order_no,
            'amount'=>$order->amount,
            'status' => $order->status,
            'address_id' => $order->address_id,
            'express_type' => $order->express_type,
            'express_no' => $order->express_no,
            'pay_time' => $order->pay_time,
            'pay_type' => $order->pay_type,
            'trade_no' => $order->trade_no,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    }

    /**
     * 额外的用户数据
    */
    public function includeUser(Order $order){
        return $this->item($order->user,new UserTransformer());
    }

    /**
     * 额外订单细节
     */
    public function includeOrderDetails(Order $order){
        return $this->collection($order->orderDetails,new OrderDetailsTransformer());
    }

    /**
     * 额外商品数据
     */
    public function includeGoods(Order $order){
        return $this->collection($order->goods,new GoodTransformer());
    }
}
