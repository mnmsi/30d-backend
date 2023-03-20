<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NamazTimeResource extends JsonResource
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
            'prayer_time'=>$this->timings,
            'arabic_month'=>$this->date->hijri,
            'timestamp'=>$this->date->timestamp
        ];
    }
}
