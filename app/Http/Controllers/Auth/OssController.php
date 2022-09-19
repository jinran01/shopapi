<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;


class OssController extends BaseController
{
    /**
     * 生成oss Token
    */
    public function token(){
        $disk = Storage::disk('oss');
        $config = $disk->signatureConfig($prefix = '/', $callBackUrl = '', $customData = [], $expire = 300);
        $configArr = json_decode($config, true);
//        dd($configArr);
        return $this->response->array($configArr);
    }
}
