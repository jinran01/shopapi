<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;

use App\Mail\SendCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordRestConrtoller extends BaseController
{
    /**
     * 获取邮箱验证码
     */
    public function emailCode(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        //发送邮箱验证码
//        $user = auth('api')->user();
        Mail::to($request->input('email'))->send(new SendCode($request->input('email')));
//        Mail::to($request->input('email'))->queue(new SendCode($request->input('email')));
//        Mail::to($user->email)->send(new SendCode($user->email));
        return $this->response->noContent();
    }

    /**
     * 找回密码
     */
    public function resetPasswordByEmail(Request $request){
        $request->validate([
            'code' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|max:16|min:6|confirmed',
        ]);
        //验证code 是否正确
//        $user = auth('api')->user();
        if (cache('email_code_'.$request->input('email')) != $request->input('code')){
            return $this->response->errorBadRequest('验证码或邮箱错误');
        }
        //更新密码
        $user = User::where('email',$request->email)->first();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return $this->response->noContent();
    }
}
