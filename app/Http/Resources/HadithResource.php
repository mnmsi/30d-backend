<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HadithResource extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title,
            'short_description' =>$this->short_description,
            'medium_description' =>$this->medium_description,
            'description' =>$this->description,
            'featured_image' =>$this->featured_image,
            'visible_time' =>$this->visible_time,
            'created_at' =>$this->created_at,
            'updated_at' =>$this->updated_at,
            'type'=>'text'
        ];
    }
}
