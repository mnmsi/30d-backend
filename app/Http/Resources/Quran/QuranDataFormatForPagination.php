<?php

namespace App\Http\Resources\Quran;

use Illuminate\Http\Resources\Json\JsonResource;

class QuranDataFormatForPagination extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
