<?php

namespace App\Listeners;

use App\Events\OrderPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToOrderUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPost  $event
     * @return void
     */
    public function handle(OrderPost $event)
    {
        //发货
        $event->order->express_type = $event->express_type;
        $event->order->express_no = $event->express_no;
        $event->order->status = 3; //发货状态
        $event->order->save();
        //发货后邮箱提醒
        Mail::to($event->order->user)->queue(new \App\Mail\OrderPost($event->order));
    }
}
