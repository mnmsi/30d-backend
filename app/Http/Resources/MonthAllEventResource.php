<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonthAllEventResource extends JsonResource
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
            'event_name' => $this->date->hijri->holidays[0],
            'gregorian_date'=>$this->date->gregorian,
            'arabic_date' => $this->date->hijri,
            'timestamp' => $this->date->timestamp
        ];
    }
}
