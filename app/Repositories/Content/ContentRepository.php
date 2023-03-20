<?php

namespace App\Repositories\Content;

use App\Http\Resources\ContentFormatinForApi;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContentRepository extends \App\Repositories\BasicRepository implements ContentRepositoryInterface
{
    /**
     * @var ContentTypeCategoryRepository
     */
    private $category;

    public function __construct(
        Model $model,
        ContentTypeCategoryRepository $contentTypeCategoryRepository
    ) {
        parent::__construct($model);
        $this->category = $contentTypeCategoryRepository;
    }

    public function getAllLifeStyleContent()
    {
        return $this->model->with('categoryId.contentType')
            ->whereHas('categoryId.contentType', function ($app) {
                $app->where('content_type', 'lifestyle');
            })->OrderBy('created_at', 'desc')
            ->paginate(16);
    }

    public function getSingleItem($id)
    {
        return $this->model->with('categoryId')
            ->where('id', $id)
            ->first();
    }

    public function createContent($data)
    {
        $result          = $this->model;
        $result['title'] = $data['title'];
        $description     = $this->convertFile($data);
        $category        = $this->category->getWithId($data['category']);
        $result->categoryId()->associate($category);
        $result['short_description'] = $data['short_description'];
        $result['content']           = $description;
        $result['featured_image']    = $data['image']->store('content', 'public');
        if (!empty($data['type'])) {
            $result['type'] = $data['type'];
        }
        $result->save();
        return $result;
    }

    public function updateContent($data)
    {

        $value                      = $this->model->find($data['id']);
        $value['title']             = $data['title'];
        $value['short_description'] = $data['short_description'];
        $value['content']           = $this->convertFile($data);
        if (isset($data['type'])) {
            $value['type'] = $data['type'];
        }
        $category = $this->category->getWithId($data['category']);
        $value->categoryId()->associate($category);
        if (isset($data['image'])) {
            Storage::disk('public')->delete($data['image']);
            $value['featured_image'] = $data['image']->store('content', 'public');
        }
        $value->save();
        return $value;
    }

    public function deleteItem($id)
    {
        return $this->model->find($id)->delete();
    }

    public function contentForSpecificItem($name)
    {
        return $this->model->with('categoryId')
            ->whereHas('categoryId', function ($app) use ($name) {
                $app->where('category_name', $name);
            })
            ->OrderBy('created_at', 'desc')
            ->paginate(16);
    }

    public function deteFile($data)
    {
        $description = $data;

        $dom = new \DomDocument();
        @$dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $k => $img) {
            $data  = $img->getattribute('src');
            $test  = explode('/', $data);
            $check = Storage::disk('public')->has('/' . $test[2] . '/' . $test[3]);
            $path  = $test[2] . '/' . $test[3];
            Storage::disk('public')->delete($path);
        }
        $description = $dom->saveHTML();
        return $description;
    }

    public function convertFile($dataT)
    {
//        $base_url = env('APP_URL');

        $description = $dataT['content'];
        $dom         = new \DomDocument();
        @$dom->loadHtml(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'));
        $images = $dom->getElementsByTagName('img');
        if (count($images) > 0)
        {
            foreach ($images as $k => $img) {
                $data = $img->getattribute('src');
                if (strpos($data, 'data') !== false) {
                    list($type, $data) = array_pad(explode(';', $data), 2, null);
                    list(, $data)      = array_pad(explode(',', $data), 2, null);
                    $dataConvert       = base64_decode($data);
                    $image_name        = time() . $k . '.png';

                    Storage::disk('public')->put('content' . DIRECTORY_SEPARATOR . $image_name, $dataConvert);
                    $path = Storage::url('content/' . $image_name);

                    $img->removeattribute('src');
                    $img->setattribute('src',$path);
                }
            }
        }

        $div = $dom->getElementsByTagName('p');
        if(count($div) > 0)
        {
            foreach ($div as $node)
            {
                $node->setAttribute('style','font-size:14px !important;');
            }
        }

        $top = $dom->getElementById('description');
//        dd($top);
        if ($top)
        {
            foreach ($top as $nodes)
            {
                $nodes->setAttribute('style','font-size:14px !important;');
            }
        }

        $description = $dom->saveHTML();
        return $description;
    }

    public function getAllEducativeContent()
    {
        return $this->model->with('categoryId.contentType')
            ->whereHas('categoryId.contentType', function ($app) {
                $app->where('content_type', 'educative');
            })->OrderBy('created_at', 'desc')
            ->paginate(16);
    }

    public function getContentByType($type)
    {

        $getCategroy = $this->category->getCategoryList($type);
        $all = [];
        foreach ($getCategroy as $category)
        {
            $result = $this->model->where('category_id',$category->id)->orderBy('created_at','desc')->take(6)->get();
            $all[$category->category_name] = ContentFormatinForApi::collection($result);
        }
        return $all;
    }

    public function getContentWithCategory($name)
    {
        return $this->model->with('categoryId')
            ->whereHas('categoryId',function($app) use ($name){
                $app->where('category_name',$name);
            })->orderBy('created_at','desc')
            ->paginate(15);
    }

    public function specificContentWithTypeCategory($id)
    {
        $data =  $this->model->with('categoryId','categoryId.contentType')
            ->where('id',$id)
            ->first();
        $data['content'] = $this->postProccessing($data['content']);
        return $data;
    }

    public function contentTypeCount($type)
    {
        return $this->model->with('categoryId','categoryId.contentType')
            ->whereHas('categoryId.contentType',function ($app) use ($type){
                $app->where('content_type',$type);
            })->get()->count();
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
        }
        $description = $dom->saveHTML();
        return $description;
    }
}
