<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use App\Models\ContentTypeCategory;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepositoryInterface;
use Illuminate\Http\Request;

class ContentCategoryController extends Controller
{

    /**
     * @var ContentTypeCategoryRepositoryInterface
     */
    private $category;

    public function __construct(ContentTypeCategoryRepositoryInterface $contentTypeCategoryRepository)
    {
        $this->category = $contentTypeCategoryRepository;
    }

    public function insert(Request $request)
    {
        return $this->category->insert($request);
    }
}
