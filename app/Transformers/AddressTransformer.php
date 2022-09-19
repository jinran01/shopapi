<?php

namespace App\Transformers;

use App\Models\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address){
        return [
            'id'=>$address->id,
            'name'=>$address->name,
            'city_id'=>$address->city_id,
            'city_name' => city_name($address->city_id),
            'address' => $address->address,
            'phone' => $address->phone,
            'created_at' => $address->created_at,
            'updated_at' => $address->updated_at,
        ];
    }
}
