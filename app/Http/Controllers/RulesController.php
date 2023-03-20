<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rules\RulesCreateRequest;
use App\Http\Requests\Rules\RulesUpdateRequest;
use App\Http\Resources\RulesResources;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepository;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepositoryInterface;
use App\Repositories\Rules\RulesRepositoryInterface;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    /**
     * @var RulesRepositoryInterface
     */
    private $rules;
    /**
     * @var ContentTypeCategoryRepository
     */
    private $contentType;

    public function __construct(
        RulesRepositoryInterface  $rulesRepository,
        ContentTypeCategoryRepositoryInterface $contentTypeCategoryRepository
    ) {
        $this->rules = $rulesRepository;
        $this->contentType = $contentTypeCategoryRepository;
    }
    public function index(Request $request)
    {
        $rules = $this->rules->getRulesList();

        return view('rules.index', ['rules' => $rules]);
    }
    public function create(Request $request)
    {
        $category = $this->contentType->getCategoryList('rules');
        return view('rules.create', ['category' => $category]);
    }
    public function createRules(RulesCreateRequest $request)
    {
        $data = $request->only('title', 'content', 'category_id');
        $result = $this->rules->createRulesNew($data);
        return redirect()->route('rules')->with('message', 'Rules create successful');
    }
    public function edit($id)
    {
        $rulesData = $this->rules->getSingleItem($id);
        $category = $this->contentType->getCategoryList('rules');
        return view('rules.edit', ['rulesData' => $rulesData, 'category' => $category]);
    }
    public function update(RulesUpdateRequest $request)
    {
        $data = $request->only('id', 'title', 'content', 'category_id');

        try {
            $result = $this->rules->updateRules($data);
            return redirect()->route('rules')->with('message', 'Rules Update successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong,Please try again letter');
        }
    }
    public function delete($id)
    {
        $delete = $this->rules->deleteItem($id);
        return redirect()->back()->with('message', 'Item delete successfully');
    }
    public function quizItems($name)
    {
        $rules = $this->rules->quizSpecificItem($name);
        return view('rules.index', ['rules' => $rules]);
    }
    public function statusUpdate($id)
    {
        try {
            $this->rules->updateStatus($id);
            return redirect()->route('rules')->with('message', 'Status Update successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong,Please try again letter');
        }
    }
    public function getAllActiveRules($slug)
    {
        $result = $this->rules->getActiveRules($slug);
        try {
            if (empty($result)) {
                $finalResult =  'No data available';
            } else {
                $finalResult = new RulesResources($result);
            }

            return ['status' => 1, 'data' => $finalResult];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'something went wrong try again letter'];
        }
    }
}
