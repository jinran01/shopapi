<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;

class PasswordController extends BaseController
{
    //
    public function updatePassword(Request $request){
        $request->validate([
               'old_password' => 'required|min:6|max:16',
                'password' => 'required|min:6|max:16|confirmed',
            ],[
            'old_password.required' => '旧密码不能为空',
            'password.required' => '新密码不能为空',
            'password.min' => '新密码至少为6个字符',
            'password.max' => '新密码最多为16个字符',
            'password.confirmed' => '两次密码输入不一致',
        ]);

        //验证旧密码是否正确
        $old_password = $request->input('old_password');
        $user = auth('api')->user();

        if(!password_verify($old_password,$user->password)){
            return $this->response->errorBadRequest('旧密码不正确');
        }

        //更新密码
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return $this->response->noContent();
    }
}
