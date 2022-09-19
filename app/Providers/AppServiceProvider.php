<?php

namespace App\Providers;

use App\Facades\Express\Express;
use App\Models\Category;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //注册自定义门面
//        $this->app->singleton('Express',function (){
//            return new Express();
//        });
        $this->app->singleton('Express',Express::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        //观察Category模型事件

        Category::observe(CategoryObserver::class);
    }
}
