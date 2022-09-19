<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendCode extends Mailable
{
    use Queueable, SerializesModels;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //生成code
        $code = rand(10000,99999);

        //缓存邮箱对应的code
        cache(['key' => $code]);
        Cache::put('email_code_'.$this->email,$code,now()->addMinute(15));

        return $this->view('emails.send-code',[
            'code' => $code,
        ]);
    }
}
