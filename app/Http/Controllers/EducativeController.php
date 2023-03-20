<?php

namespace App\Http\Controllers;

use App\Http\Requests\Content\ContentCreateRequest;
use App\Http\Requests\Content\ContentUpdateRequest;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\Educative\EducativeRepositoryInterface;

class EducativeController extends Controller
{

    /**
     * @var EducativeRepositoryInterface
     */
    private $educative;
    /**
     * @var ContentRepositoryInterface
     */
    private $content;

    public function __construct(
        EducativeRepositoryInterface $educativeRepository,
        ContentRepositoryInterface $contentRepository
    ) {
        $this->educative = $educativeRepository;
        $this->content   = $contentRepository;
    }

    public function index()
    {
        $allContent = $this->content->getAllEducativeContent();
        return view('educative.index', ['contents' => $allContent]);
    }

    public function create()
    {
        $categories = $this->educative->getCategoryList();
        return view('educative.content-create-page', ['categories' => $categories]);
    }

    public function store(ContentCreateRequest $request)
    {
        $data = $request->only('title', 'category', 'type', 'short_description', 'content', 'image');

        try {
            $result = $this->content->createContent($data);
            return redirect()->route('educatie')->with('message', 'Educatie Added successfully');

        } catch (\Exception $e) {

            return redirect()->back()->with('message', 'Something went wrong, Please try again letter');
        }
    }

    public function edit($id)
    {
        $categories = $this->educative->getCategoryList();
        $data       = $this->content->getSingleItem($id);

        return view('educative.edit', ['categories' => $categories, 'data' => $data]);
    }

    public function update(ContentUpdateRequest $request)
    {
        $data = $request->only('title', 'id', 'category', 'video_url', 'short_description', 'content', 'image','type');

        try {
            $result = $this->content->updateContent($data);
            return redirect()->route('educatie')->with('message', 'Educatie Update successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong,Please try again letter');
        }
    }

    public function delete($id)
    {
        $delete = $this->content->deleteItem($id);
        return redirect()->back()->with('message', 'Item delete successfully');
    }

    public function educativeContent($name)
    {
        $contents = $this->content->contentForSpecificItem($name);
        return view('educative.index', ['contents' => $contents]);
    }
}
