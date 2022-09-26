<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;

class ResetAvatarController extends BaseController
{
    //
    public function updateAvatar(Request $request){
        $request->validate([
            'avatar'=>'required'
        ]);
        $user = auth('api')->user();
        $user->avatar = $request->input('avatar');
        $user->save();
        return $this->response->noContent();
    }
}
