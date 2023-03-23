<?php


namespace App\Repositories\lifeStyle;


use App\Repositories\BasicRepository;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepositoryInterface;

class LifeStyleRepository implements LifeStyleRepositoryInterface
{

    /**
     * @var ContentTypeCategoryRepositoryInterface
     */
    private $category;
    /**
     * @var ContentRepositoryInterface
     */
    private $content;

    public function __construct(
        ContentTypeCategoryRepositoryInterface $contentTypeCategoryRepository,
        ContentRepositoryInterface             $contentRepository
    )
    {
        $this->category = $contentTypeCategoryRepository;
        $this->content = $contentRepository;
    }


    public function getCategoryList()
    {
        return $this->category->getCategoryList('lifestyle');
    }
}
