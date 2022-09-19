<?php

namespace App\Listeners;

use App\Events\SendSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;

class SendSmsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendSms  $event
     * @return void
     */
    public function handle(SendSms $event)
    {

        $config = config('sms');
        $easySms = new EasySms($config);
        $code = rand(1000,9999);
        //缓存验证码
        Cache::put('phone_code_'.$event->phone,$code,now()->addMinute(10));

        try {
            $easySms->send($event->phone,[
                'template' => $config['template'],
                'data' => [
                    'code' => $code
                ],
            ]);
        }catch (\Exception $e){
            return $e->getExceptions();
        }
    }
}
