<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContentFormatinForApi;
use App\Http\Resources\ContentWithCategory;
use App\Http\Resources\LinkCollectionResource;
use App\Models\ContentType;
use Illuminate\Http\Request;
use App\Repositories\Content\ContentRepositoryInterface;


class ContentController extends Controller
{
    /**
     * @var ContentRepositoryInterface
     */
    private $content;

    public function __construct(ContentRepositoryInterface $contentRepository) {
        $this->content   = $contentRepository;
    }

    public function getContentByType(Request $request)
    {
        $result =  $this->content->getContentByType($request->type);
        return ['status'=>0,'data'=>$result];
    }

    public function contentWithCategory(Request $request)
    {
        $result =  $this->content->getContentWithCategory($request->name);
        return ContentFormatinForApi::collection($result);
    }

    public function contentSpecificDetails($id)
    {
        $result  = $this->content->specificContentWithTypeCategory($id);
        return new ContentWithCategory($result);
    }

    public function onlyContent($id)
    {
        $data = $this->content->getItemWithId($id);
        return $data->content;
    }
}
