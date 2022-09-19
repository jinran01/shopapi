<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;


class SlidesRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'img' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => '标题必填',
            'img.required' => '图片地址必填',
        ];
    }
}
