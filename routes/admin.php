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

    $api->group(['prefix'=> 'admin'],function ($api){
        //需要登陆的路由组
        $api->group(['middleware' => ['api.auth','check.permission']],function ($api){

            /**
             * 用户管理
            */
            //用户启用/禁用
            $api->patch('users/{user}/lock',[\App\Http\Controllers\Admin\UserController::class,'lock'])->name('users.lock');

            //用户资源管理路由
            $api -> resource('users',\App\Http\Controllers\Admin\UserController::class,[
                'only' => ['index','show']
            ]);

            /**
             * 分类管理
            */

            //分类启用/禁用
            $api->patch('category/{category}/status',[\App\Http\Controllers\Admin\CategoryController::class,'status'])->name('category.status');
            //用户资源路由
            $api -> resource('category',\App\Http\Controllers\Admin\CategoryController::class,[
                'except' => 'destroy'
            ]);

            /**
             * 商品管理
            */
            //是否上架
            $api->patch('goods/{good}/on',[\App\Http\Controllers\Admin\GoodsController::class,'isOn'])->name('goods.on');
            //是否推荐
            $api->patch('goods/{good}/recommend',[\App\Http\Controllers\Admin\GoodsController::class,'isRecommend'])->name('goods.recommend');
            //商品资源路由
            $api -> resource('goods',\App\Http\Controllers\Admin\GoodsController::class,[
                'except' => 'destroy'
            ]);

            /**
             * 评论管理
             */
            //评价列表
            $api->get('comments',[\App\Http\Controllers\Admin\CommentController::class,'index'])->name('comments.index');
            //评价详情
            $api->get('comments/{comment}',[\App\Http\Controllers\Admin\CommentController::class,'show'])->name('comments.show');
            //回复评价
            $api->patch('comments/{comment}/reply',[\App\Http\Controllers\Admin\CommentController::class,'reply'])->name('comments.reply');

            /**
             * 订单管理
             */
            //订单列表
            $api->get('orders',[\App\Http\Controllers\Admin\OrderController::class,'index'])->name('orders.index');
            //订单详情
            $api->get('orders/{order}',[\App\Http\Controllers\Admin\OrderController::class,'show'])->name('orders.show');
            //订单发货
            $api->patch('orders/{order}/post',[\App\Http\Controllers\Admin\OrderController::class,'post'])->name('orders.post');

            /**
             * 轮播图管理
             */
            //排序
            $api->patch('slides/{slide}/seq',[\App\Http\Controllers\Admin\SlidesController::class,'seq'])->name('slides.seq');
            //轮播图的禁用/启用
            $api->patch('slides/{slide}/status',[\App\Http\Controllers\Admin\SlidesController::class,'status'])->name('slides.status');
            //轮播图资源管理路由//排序
            $api->resource('slides',\App\Http\Controllers\Admin\SlidesController::class);

            /**
             * 菜单管理
             */
            $api -> get('menus',[\App\Http\Controllers\Admin\MenuController::class,"index"])->name('menus.index');
        });
    });
});

