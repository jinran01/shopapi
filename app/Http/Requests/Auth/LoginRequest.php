<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Rules\Userconfirmed;


class LoginRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'email' => 'required|email',
            'password' => 'required|min:6|max:16',
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'邮箱不能为空',
            'email.email'=>'请输入正确的邮箱',
            'password.required'=>'密码不能为空',
        ];
    }
}
