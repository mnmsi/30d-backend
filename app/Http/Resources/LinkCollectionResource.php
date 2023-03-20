<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        dd($request);
        return [
            'current_page' => $this->current_page,
            'first_page_url'=>$this->first_page_url,
            'next_page_url'=>$this->next_page_url,
            'from'=>$this->from,
            'to'=>$this->to
        ];
    }
}
