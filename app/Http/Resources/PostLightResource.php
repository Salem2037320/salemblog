<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostLightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => str_limit($this->content,150,'...'),
            'image' => $this->image,
            'userName' => $this->user->name .'-'. $this->user->id,
            'created_at' => $this->created_at->format('D m Y,h:s a'),
            'viewCount' => $this->getViewsCountAttribute(),
            'url' => route('post.show', $this->id)
        ];
    }
}
