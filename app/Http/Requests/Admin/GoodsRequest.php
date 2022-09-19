<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;


class GoodsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'description' => 'required|max:255',
            'price' => 'required|min:0',
            'stock' => 'required|min:0',
            'cover' => 'required',
            'pics' => 'required|array',
            'detail' => 'required',
        ];
    }
}
