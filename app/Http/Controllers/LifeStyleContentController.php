<?php

namespace App\Http\Controllers;

use App\Http\Requests\LifeStyle\LifeStyleCreateRequest;
use App\Http\Requests\LifeStyle\LifeStyleUpdateRequest;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\lifeStyle\LifeStyleRepositoryInterface;
use Illuminate\Http\Request;

class LifeStyleContentController extends Controller
{

    /**
     * @var LifeStyleRepositoryInterface
     */
    private $lifeStyle;
    /**
     * @var ContentRepositoryInterface
     */
    private $content;

    public function __construct(
        LifeStyleRepositoryInterface $lifeStyleRepository,
        ContentRepositoryInterface $contentRepository
    )
    {
        $this->lifeStyle = $lifeStyleRepository;
        $this->content = $contentRepository;
    }

    public function index()
    {
        $allContent = $this->content->getAllLifeStyleContent();
        return view('lifeStyle.index',['contents'=>$allContent]);
    }

    public function lifeStyleCreatePageShow()
    {
        $categories = $this->lifeStyle->getCategoryList();
        return view('lifeStyle.content-create-page',['categories'=>$categories]);
    }

    public function createLifeStyle(LifeStyleCreateRequest $request)
    {
        $data = $request->only('title','category','type','short_description','content','image');
        try {
            $result = $this->content->createContent($data);
            return redirect()->route('life-style')->with('message','Life style Added successfully');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('message','Something went wrong,Please try again letter');
        }
    }

    public function editLifeStyleContent($id)
    {
        $categories = $this->lifeStyle->getCategoryList();
        $data = $this->content->getSingleItem($id);
        return view('lifeStyle.edit-page-show',['categories'=>$categories,'data'=>$data]);
    }

    public function updateLifeStyleContent(LifeStyleUpdateRequest $request)
    {
        $data = $request->only('title','id','category','type','short_description','content','image');
        try {
            $result = $this->content->updateContent($data);
            return redirect()->route('life-style')->with('message','Life style Update successfully');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('message','Something went wrong,Please try again letter');
        }
    }

    public function deleteContent($id)
    {
        $delete = $this->content->deleteItem($id);
        return redirect()->back()->with('message','Item delete successfully');
    }

    public function lifeStyleSportsItem($name)
    {
        $contents = $this->content->contentForSpecificItem($name);
        return view('lifeStyle.index',['contents'=>$contents]);
    }
}
