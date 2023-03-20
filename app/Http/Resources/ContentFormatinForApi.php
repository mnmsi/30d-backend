<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContentFormatinForApi extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title,
            'content'=>$this->postProccessing($this->content),
            'type'=>$this->type,
            'short_description'=>$this->short_description,
            'featured_image'=>$this->featured_image,
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

        foreach ($ireame as $k=>$frame)
        {

            $frame->setattribute('src',"https:".$frame->getattribute('src'));

        }

        foreach ($images as $k => $img) {
            $img->setattribute('src',$base_url.$img->getattribute('src'));
            $data = $img->getattribute('src');
        }
//        $dom->getElementsByTagName('body')
        $description = $dom->saveHTML();
        return $description;
    }
}
