<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\BaseRequest;


class RegisterRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:16',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:16|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'昵称不能为空',
            'name.max'=>'昵称不能超过16个字符',
            'email.required'=>'邮箱不能为空',
            'password.required'=>'密码不能为空',
            'password.confirmed'=>'输入的两次密码不一致',
            'email.unique'=>'邮箱已存在',

        ];
    }
}
