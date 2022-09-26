<?php

namespace App\Http\Controllers\Api;

use App\Facades\Express\Facade\Express;
use App\Http\Controllers\BaseController;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Good;
use App\Models\Order;
use App\Transformers\AddressTransformer;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * 订单列表
     */
    public function index(Request $request){

        $status = $request->query('status');
        $title = $request->query('title');

        $order = Order::where('user_id',auth('api')->id())
            ->when($status,function ($query) use ($status){
                $query->where('status',$status);
            })
            ->when($title,function ($query) use ($title){
                $query->whereHas('goods',function ($query) use ($title){
                    $query->where('title','like',"%{$title}%");
                });
            })
            ->paginate(3);
        return $this->response->paginator($order, new OrderTransformer());
    }
    /**
     * 订单预览
    */
    public function preview(){
        //地址信息
        $address = Address::where('user_id',auth('api')->id())
            ->orderBy('is_default','desc')
            ->get();
        foreach ($address as $a){
            $a['city_name'] = city_name($a->city_id);
        }

        //购物车数据信息
        $carts = Cart::where('user_id',auth('api')->id())
            ->where('is_checked',1)
            ->with('goods:id,cover,title,description,price')
            ->get();

        //判断购物车是否有选择商品
        if ($carts->isEmpty()){
            $this->response->errorBadRequest('您还没有选择商品哦');
        }
        //返回数据
        return $this->response->array([
            'address' => $address,
            'carts' => $carts,
        ]);
    }
    /**
     * 提交订单
     */
    public function store(Request $request){
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ],[
            'address_id.required' => '收货地址不能为空'
        ]);
        //处理插入的数据
        $user_id = auth('api')->id();
        $order_no = date('YmdHis').rand(100000,999999);
        $amount = 0;
        $carts = Cart::where('user_id',$user_id)
            ->where('is_checked',1)
            ->with('goods:id,price,stock,title')
            ->get();
        //判断购物车是否有选择商品
        if ($carts->isEmpty()){
            $this->response->errorBadRequest('您还没有选择商品哦');
        }
        //要插入的订单数据
        $insertData = [];
        foreach ($carts as $key => $cart ){
            //如有商品库存不足，提示用户重新选择
            if ($cart->goods->stock < $cart->num){
                $this->response->errorBadRequest($cart->goods->title.'库存不足请重新选择商品');
            }
            $insertData[] = [
                'goods_id' => $cart->goods_id,
                'price' => $cart->goods->price,
                'num' => $cart->num,
            ];
            $amount += $cart->goods->price * $cart->num;
        }
       try{
            DB::beginTransaction();
           //生成订单
           $order = Order::create([
               'user_id' => $user_id,
               'order_no' => $order_no,
               'amount' => $amount,
               'address_id' => $request->input('address_id')
           ]);
           //生成订单的详情
           $order->orderDetails()->createMany($insertData);
           //删除已经结算的购物车数据
           Cart::where('user_id',$user_id)
               ->where('is_checked',1)
               ->delete();
           //减去对应商品的库存
           foreach ($carts as $cart){
               Good::where('id',$cart->goods_id)
                   ->decrement('stock',$cart->num);
           }
           DB::commit();
//           return $this->response->created();
           return $order;
       }catch (\Exception $e){
            //数据库回滚
            DB::rollBack();
            throw $e; //抛出异常
       }
    }
    /**
     * 订单详情
     */
    public function show(Order $order){
        return $this->response->item($order,new OrderTransformer());
    }

    /**
     * 物流查询
     */
    public function express(Order $order){
        if (!in_array($order->status,[3,4])){
            return $this->response->noContent();
        }

//        $express =new Express();
        $result = Express::track($order->order_no,$order->express_type,$order->express_no);

        if (isset($result['Success']) && !$result['Success']){

           return $this->response->errorBadRequest($result['Reason']);
        }

        return $this->response->array($result);
    }
    /**
     * 确认收货
     */
    public function confirm(Order $order){
        if ($order->status != 3){
            return $this->response->errorBadRequest('订单状态异常');
        }
        try {
            DB::beginTransaction();
            $order->status = 4;
            $order->save();
            $orderDetails = $order->orderDetails;
            //增加订单下的所有商品的销量
            foreach ($orderDetails as $orderDetail){
                //更新商品销量
                Good::where('id',$orderDetail->goods_id)->increment('sales',$orderDetail->num);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return $this->response->noContent();

    }

}
