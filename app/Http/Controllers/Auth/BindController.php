<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendSms;
use App\Http\Controllers\BaseController;

use App\Mail\SendCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Overtrue\EasySms\EasySms;

class BindController extends BaseController
{

    public function __construct()
    {
        $this->middleware(['check.phone.code'])->only(['updatePhone']);
    }

    /**
    * 获取邮箱验证码
    */
    public function emailCode(Request $request){
//        $request->validate([
//            'email' => 'required|email',
//        ]);
        //发送邮箱验证码
        $user = auth('api')->user();
//        Mail::to($request->input('email'))->send(new SendCode($request->input('email')));
//        Mail::to($request->input('email'))->queue(new SendCode($request->input('email')));
        Mail::to($user->email)->send(new SendCode($user->email));

        return $this->response->noContent();
    }


    /**
     * 更新邮箱
     */
    public function updateEmail(Request $request){
        $request->validate([
            'code' => 'required',
            'email' => 'required|email|unique:users',
        ]);
        //验证code 是否正确
        $user = auth('api')->user();
        if (cache('email_code_'.$user->email) != $request->input('code')){
            return $this->response->errorBadRequest('验证码或邮箱错误');
        }
        //更新邮箱
//        $user = auth('api')->user();
        $user->email = $request->input('email');
        $user->save();

        return $this->response->noContent();
    }


    /**
     * 获取手机验证码
     */
    public function phoneCode(Request $request){
        $request->validate([
            'phone' => 'required|regex:/^1[3-9]\d{9}$/',
        ]);
        //发送手机验证码
        $user = auth('api')->user();
        $phone = $user->phone != '' ? $user->phone : $request->input('phone');
        SendSms::dispatch($phone);
//        SendSms::dispatch($request->input('phone'));
        return $this->response->noContent();
    }

    /**
     * 更新手机
     */
    public function updatePhone(Request $request){

        $request->validate([
            'phone' => 'unique:users',
        ]);
        //更新手机号
        $user = auth('api')->user();
        $user->phone = $request->input('phone');
        $user->save();
        return $this->response->noContent();
    }
}
