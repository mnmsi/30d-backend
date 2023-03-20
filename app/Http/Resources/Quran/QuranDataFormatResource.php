<?php

namespace App\Http\Resources\Quran;

use Illuminate\Http\Resources\Json\JsonResource;

class QuranDataFormatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //        dd($this);
        return [
            'arabic_text' => $this['text_uthmani'],
            'translation_text' => $this['translations'][0]['text'],
            'sajdah_type' => $this['sajdah_type'],
            'sajdah_number' => $this['sajdah_number'],
            'audio' => 'https://verses.quran.com/' . $this['audio']['url']
        ];
    }
}
