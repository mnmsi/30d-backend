<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AllNewsCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        setlocale(LC_ALL, 'nl_NL'.'.utf8');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'type' => $this->type,
            'featured_image' => $this->featured_image,
            'content' => $this->postProccessing($this->content),
            'video_url' => $this->video_url,
            'created_at'=>ucwords(strftime('%d %B %Y', strtotime($this->created_at))),
            'updated_at'=>ucwords(strftime('%d %B %Y', strtotime($this->updated_at))),
        ];
    }

    public function postProccessing($data)
    {
        $base_url = env('APP_URL');
        $description = $data;
        $dom         = new \DomDocument();
        @$dom->loadHtml(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'));
        $ireame = $dom->getElementsByTagName('iframe');
        $images = $dom->getElementsByTagName('img');

        foreach ($ireame as $k => $frame) {

            $frame->setattribute('src', "https:" . $frame->getattribute('src'));
            //            dd($frame->getattribute('src'));
        }

        foreach ($images as $k => $img) {
            $img->setattribute('src', $base_url . $img->getattribute('src'));
            $data = $img->getattribute('src');
        }
        $description = $dom->saveHTML();
        return $description;
    }
}
