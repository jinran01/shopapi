<?php

namespace App\Transformers;

use App\Models\Slides;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class SlidesTransformer extends TransformerAbstract
{
    public function transform(Slides $slides){
        return [
            'id'=>$slides->id,
            'title'=>$slides->title,
            'img'=>$slides->img,
            'url' => $slides->url,
            'img_url' => oss_url($slides->img),
            'status' => $slides->status,
            'seq' => $slides->seq,
            'created_at' => $slides->created_at,
            'updated_at' => $slides->updated_at,
        ];
    }
}
