<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsPortal\NewsPortalCreateRequest;
use App\Http\Requests\NewsPortal\NewsPortalUpdateRequest;
use App\Http\Resources\AllNewsCollection;
use App\Http\Resources\HadithResource;
use App\Repositories\NewsPortal\NewsPortalRepositoryInterface;

class NewsPortalController extends Controller
{
    /**
     * @var NewsPortalRepositoryInterface
     */
    private $newsPortalRepo;

    public function __construct(NewsPortalRepositoryInterface $newsPortalRepo)
    {
        $this->newsPortalRepo = $newsPortalRepo;
    }

    public function index()
    {
        $news = $this->newsPortalRepo->getNewsList();
        return view('newsPortal.index', ['news' => $news]);
    }

    public function create()
    {
        return view('newsPortal.create');
    }

    public function store(NewsPortalCreateRequest $request)
    {
        $data = $request->only('title', 'video_url', 'short_description', 'content', 'image');

        try {
            $result = $this->newsPortalRepo->createNews($data);
            return redirect()->route('newsPortal')->with('message', 'News Added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong, Please try again letter');
        }
    }

    public function edit($id)
    {
        $newsData = $this->newsPortalRepo->getSingleItem($id);
        return view('newsPortal.edit', ['newsData' => $newsData]);
    }

    public function update(NewsPortalUpdateRequest $request)
    {
        $data = $request->only('id', 'title', 'video_url', 'short_description', 'content', 'image');

        try {
            $result = $this->newsPortalRepo->updateNews($data);
            return redirect()->route('newsPortal')->with('message', 'News Update successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong,Please try again letter');
        }
    }

    public function delete($id)
    {
        $delete = $this->newsPortalRepo->deleteItem($id);
        return redirect()->back()->with('message', 'Item delete successfully');
    }

    public function getAllNewsList()
    {

        $data =  $this->newsPortalRepo->getNewsList();
        return AllNewsCollection::collection($data);
    }

    public function getSingleNewsWithId($id)
    {
        $result = $this->newsPortalRepo->getSingleItem($id);

        return ['status'=>1,'data'=>$result];
    }

    public function test()
    {
        $result = $this->newsPortalRepo->getSingleItem(2);
        return view('newsPortal.test',['data'=>$result]);
    }
}
