<?php

namespace App\Facades\Express;

use Illuminate\Support\Facades\Http;

class Express
{
    //商户ID
    protected $EBusinessID;
    //API Key
    protected $ApiKey;

    //模式
    protected $mode;

    public function __construct(){
        $config = config('express');
        $this->EBusinessID = $config['EBusinessID'];
        $this->ApiKey = $config['ApiKey'];
        $this->mode = $config['mode'] ?? 'product';
    }
    /**
     * 即时查询快递信息
    */
    public function track($OrderCode,$ShipperCode,$LogisticCode){

        $requestData= "{'OrderCode':'{$OrderCode}','ShipperCode':'{$ShipperCode}','LogisticCode':'{$LogisticCode}'}";


        //发送请求
        $result = Http::asForm()
            ->post(
                $this->url('track'),$this
                ->formateReqData($requestData,'1002')
            );
        return $this->formateResData($result);
    }
    /**
     * 格式化请求参数
    */
    protected function formateReqData($requestData,$RequestType){
        $datas = array(
            'EBusinessID' => $this->EBusinessID,
            'RequestType' => $RequestType, //免费即时查询接口指令1002/在途监控即时查询接口指令8001/地图版即时查询接口指令8003
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData);
        return $datas;
    }
    /**
     * 格式化响应参数
     */
    protected function formateResData($result){
        return json_decode($result,true);
    }

    /**
     * 电商Sign签名生成
     */
    function encrypt($data) {
        return urlencode(base64_encode(md5($data.$this->ApiKey)));
    }

    /**
     * 返回Api url
     */

    public function url($type){
        $url = [
            'track'=>[
                'product' => 'https://api.kdniao.com/api/dist',
                'dev' => 'http://sandboxapi.kdniao.com:8080/kdniaosandbox/gateway/exterfaceInvoke.json',
            ]
        ];
        return $url[$type][$this->mode];
    }
}
