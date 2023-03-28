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
            'sub_title' =>$this->short_description,
            'description_en' =>$this->medium_description,
            'description_ar' =>$this->description,
            'image' =>$this->featured_image,
            'data' =>$this->visible_time,
//            'created_at' =>$this->created_at,
//            'updated_at' =>$this->updated_at,
//            'type'=>'text'
        ];
    }
}
