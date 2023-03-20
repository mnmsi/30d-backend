<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use League\CommonMark\Block\Element\ThematicBreak;

class ContentWithCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $type =(new checkContentType($this->categoryId));
        return [
            'id' => $this->id,
            'category_name' => $this->categoryId->category_name,
            'category_id' => $this->categoryId->id,
            'content_type' => $type->contentType->content_type,
            'title' => $this->title,
            'content' => $this->content,
            'short_description' => $this->short_description,
            'featured_image' => $this->featured_image,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ];

    }

}
class checkContentType extends JsonResource
{
    public function toArray($request)
    {
        return ['name'=>$this->contentType->content_type];
    }
}
