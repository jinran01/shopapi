<?php

namespace App\Http\Middleware;

use App\Events\SendSms;
use Closure;
use Illuminate\Http\Request;

class CheckPhonCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'code' => 'required',
            'phone' => 'required|regex:/^1[3-9]\d{9}$/',
        ]);
        //验证code 是否正确
        $user = auth('api')->user();
        $phone = $user->phone != '' ? $user->phone : $request->input('phone');
        if (cache('phone_code_'.$phone) != $request->input('code')){
            abort(400,'验证码或者手机号错误');
        }
        //验证code 是否正确
//        if (cache('email_code_'.$request->input('phone')) != $request->input('code')){
//           abort(400,'验证码或者手机号错误');
//        }

        return $next($request);
    }
}
