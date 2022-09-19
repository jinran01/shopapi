<?php
$api = app('Dingo\Api\Routing\Router');
$params = ['middleware' =>
    ['api.throttle',
        'bindings',
        'serializer:array' //减少transformer包裹层
    ],
    'limit' => 10,
    'expires' => 1
];

$api->version('v1',$params, function ($api) {
    //首页信息
    $api->get('/index',[\App\Http\Controllers\Api\IndexController::class,'index']);
    //商品详情
    $api->get('goods/{good}',[\App\Http\Controllers\Api\GoodsController::class,'show']);
    //商品列表
    $api->get('goods',[\App\Http\Controllers\Api\GoodsController::class,'index']);

    /**
     * 回调
    */
    //支付成功支付成功回调
    $api->any('pay/notify/aliyun',[\App\Http\Controllers\Api\PayController::class,'notifyAliyun']);

    //需要登陆的路由组
    $api->group(['middleware' => 'api.auth'],function ($api){
        /**
         * 个人中心
        */
        //用户详情
        $api -> get('user',[\App\Http\Controllers\Api\UserController::class,'userInfo']);
        //更新信息
        $api -> put('user',[\App\Http\Controllers\Api\UserController::class,'updateUserInfo']);
        //用户详情
        $api -> patch('user/avatar',[\App\Http\Controllers\Api\UserController::class,'updateAvatar']);
        /**
         * 购物车
         */
        $api -> resource('carts',\App\Http\Controllers\Api\CartController::class,[
            'except' => 'show'
        ]);
        /**
         * 订单
         */

        //订单预览
        $api->get('orders/preview',[\App\Http\Controllers\Api\OrderController::class,'preview']);
        //提交订单
        $api->post('orders',[\App\Http\Controllers\Api\OrderController::class,'store']);
        //订单详情
        $api->get('orders/{order}',[\App\Http\Controllers\Api\OrderController::class,'show']);
        //订单列表
        $api->get('orders',[\App\Http\Controllers\Api\OrderController::class,'index']);
        //物流查询
        $api->get('orders/{order}/express',[\App\Http\Controllers\Api\OrderController::class,'express']);
        //确认收货
        $api->patch('orders/{order}/confirm',[\App\Http\Controllers\Api\OrderController::class,'confirm']);
        //评论商品
        $api->post('orders/{order}/comment',[\App\Http\Controllers\Api\CommentController::class,'store']);
        /**
         * 支付
         */

        //获取支付信息
        $api->get('orders/{order}/pay',[\App\Http\Controllers\Api\PayController::class,'pay']);
        //轮询查询支付状态
        $api->get('orders/{order}/status',[\App\Http\Controllers\Api\PayController::class,'payStatus']);

        /**
         * 地址
         */

        //省市县数据
        $api->get('city',[\App\Http\Controllers\Api\CityController::class,'index']);
        //获取city_id
        $api->get('city/city_id',[\App\Http\Controllers\Api\CityController::class,'city_id']);
        //地址相关的资源路由
        $api->resource('address',\App\Http\Controllers\Api\AddressController::class);
        //默认地址设置
        $api->patch('address/{address}/default',[\App\Http\Controllers\Api\AddressController::class,'default']);

    });

});

