<?php

namespace App\Console;

use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
//        $schedule->call(function (){
//           info('hello');
//        })->everyMinute();
        //定时检测，超过时间未支付的，作废
        $schedule->call(function (){
            $orders = Order::where('status',1)
                ->where('created_at','<',date("Y-m-d H:i:s",time()-1800))
                ->with('orderDetails.goods')
                ->get();
            //循环订单，修改订单状态，还原库存
            try{
                DB::beginTransaction();
                foreach ($orders as $order){
                    $order->status = 5;
                    $order->save();
                    //还原商品库存
                    foreach ($order->orderDetails as $details){
                        $details->goods->increment('stock',$details->num);
                    }
                }
                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();
                Log::alert($e);
            }

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
