<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

use App\Http\Requests\Admin\SlidesRequest;

use App\Models\Slides;
use App\Transformers\SlidesTransformer;
use Illuminate\Http\Request;

class SlidesController extends BaseController
{
    /**
     * 轮播图列表
     */
    public function index()
    {
        $slides = Slides::paginate(2);
        return $this->response->paginator($slides,new SlidesTransformer());
    }

    /**
     * 添加轮播图
     */
    public function store(SlidesRequest $request)
    {
        $max_seq = Slides::max('seq') ?? 0;
        $max_seq++;
        $request->offsetSet('seq',$max_seq);
        Slides::create($request->all());
        return $this->response->created();
    }

    /**
     * 轮播图详情
     */
    public function show(Slides $slide)
    {
        return $this->response->item($slide,new SlidesTransformer());
    }

    /**
     * 更新轮播图
     */
    public function update(SlidesRequest $request, Slides $slide)
    {
        $slide->update($request->all());

        return $this->response->noContent();
    }

    /**
     * 删除轮播图
     */
    public function destroy(Slides $slide)
    {
        $slide->delete();
        return $this->response->noContent();
    }

    /**
     * 排序轮播图
     */
    public function seq(Request $request, Slides $slide)
    {
        $slide->seq = $request->input('seq',1);
        $slide->save();
        return $this->response->noContent();
    }

    /**
     * 轮播图禁用/启用
     */
    public function status(Slides $slide)
    {
        $slide->status = $slide->status == 1 ? 0 : 1;
        $slide->save();
        return $this->response->noContent();
    }

}
