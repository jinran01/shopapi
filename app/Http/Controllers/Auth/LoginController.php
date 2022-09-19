<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;


class LoginController extends BaseController
{
    /**
        用户登录
     **/
    public function login(LoginRequest $request)
    {

        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return  response()->json(['errors' => ['msg'=>['密码或账号错误']]], 422);
        }

        //检查用户状态

        $user = auth('api')->user();
        if($user -> is_locked == 1){
            return $this->response->errorForbidden('该用户被锁定');
        }
        return $this->respondWithToken($token);
    }


    /**
     * 退出登录
     */
    public function logout()
    {

        auth('api')->logout();

        return response()->json(['message' => '退出成功','code'=>'200']);
    }

    /**
     * 刷新token.
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * 格式化返回
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
