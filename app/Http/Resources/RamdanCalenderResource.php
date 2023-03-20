<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RamdanCalenderResource extends JsonResource
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
            'sehri_time'=>$this->timings->Imsak,
            'ifter_time'=>$this->timings->Maghrib,
            'fajar_time'=>$this->timings->Fajr,
            'eng_date'=>$this->date->readable,
            'hijri_date'=>$this->date->hijri->date,
            'hijri_month'=>$this->date->hijri->month->en,
            'timestamp'=>$this->date->timestamp
        ];
    }
}
