<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;

use App\Models\Cart;
use App\Models\Good;
use App\Transformers\CartTransformer;
use Illuminate\Http\Request;

class CartController extends BaseController
{

    /**
     * 购物车商品列表
     */
    public function index()
    {
        $carts = Cart::where('user_id',auth('api')->id())->get();
        return $this->response->collection($carts,new CartTransformer());
    }

    /**
     * 加入购物车
     */
    public function store(Request $request)
    {
        $request->validate([
//            'user_id'=>'',
            'goods_id'=>'required|exists:goods,id',
            'num'=>[
                function($attribute,$value,$fail) use($request){
                    $goods = Good::find($request->goods_id);
                    if ($value > $goods->stock){
                        $fail('购买数量不能超过库存');
                    }
                }
            ],
        ],[
            'goods_id.required' => '商品id不能为空',
            'goods_id.exists' => '商品id不存在',
        ]);
        //检查购物车是否存在该数据
        $cart = Cart::where('user_id',auth('api')->id())
            ->where('goods_id',$request->input('goods_id'))
            ->first();
        //存在该数据
        if (!empty($cart)){
            $cart->num += $request->input('num',1);//在该数量的基础上相加
            $cart->save();
            return $this->response->noContent();
        }

        Cart::create([
            'user_id'=>auth('api')->id(),
            'goods_id'=>$request->input('goods_id'),
            'num'=>$request->input('num',1),
        ]);
        return $this->response->created();
    }

    /**
     *数量增加减少
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'num' => [
                'required',
                'gte:1',
                function($attribute,$value,$fail) use($cart){
                    if ($value > $cart->goods->stock){
                        $fail('购买数量不能超过库存');
                    }
            }],
        ],[
            'num.required'=> '数量不能为空',
            'num.gte'=> '数量最少是1',
        ]);
        $cart->num = $request->input('num');
        $cart->save();
        return $this->response->noContent();
    }

    /**
     * 移除购物车
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return $this->response->noContent();
    }
}
