<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 用户列表
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('emails');

        $users = User::when($name,function ($query) use ($name){

            $query->where('name','like',"%$name%");
        })
            ->when($email,function ($query)use ($email){
                $query->where('emails',$email);
        })
            ->paginate(3);
        return $this->response->paginator($users,new UserTransformer());
    }

    /**
     * 用户详情
     */
    public function show(User $user)
    {
        return $this->response->item($user,new UserTransformer());
    }
    /**
     * 用户禁用
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 0 ? 1 : 0;
        $user->save();
        return $this->response->noContent();
    }
}
