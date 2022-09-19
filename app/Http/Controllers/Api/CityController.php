<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends BaseController
{
    //省市县数据
    public function index(Request $request){

        return city_cache($request->query('pid',0));
//        $city = City::with('children.children.children')->where('id',1)->get();

    }

    //获取city_id
    public function city_id(Request $request){
        $request->validate([
            'county' => 'required'
        ]);
        $data = City::where('name',$request->input('county'))->get();
        if (sizeof($data) ==0) return 1;
        return $data[0]['id'];
    }
}
