<?php


namespace App\Repositories\Rules;


use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RulesRepository extends \App\Repositories\BasicRepository implements RulesRepositoryInterface
{
    /**
     * @var ContentRepositoryInterface
     */
    private $content;
    /**
     * @var ContentTypeCategoryRepositoryInterface
     */
    private $categoryType;

    public function __construct(
        Model $model,
        ContentTypeCategoryRepositoryInterface $contentTypeCategoryRepository,
        ContentRepositoryInterface $contentRepository
    )
    {
        parent::__construct($model);
        $this->content = $contentRepository;
        $this->categoryType = $contentTypeCategoryRepository;
    }


    public function  createRulesNew($data)
    {
        $result = $this->model;

        $result['title'] = $data['title'];
        $result['description'] = $this->content->convertFile($data);

        $category = $this->categoryType->getWithId($data['category_id']);
        $result->categoryType()->associate($category);

        $result->save();
        return $result;

    }
    public function getRulesList()
    {
        return $this->model
            ->with('categoryType')
            ->OrderBy('created_at', 'desc')
            ->paginate(15);
    }
    public function getSingleItem($id)
    {
        return $this->model
            ->where('id', $id)
            ->first();
    }
    public function updateRules($data)
    {
        $rules                  =$this->model->find($data['id']);

        $rules['title']         = $data['title'];
        $rules['description']   = $this->content->convertFile($data);

        $category               = $this->categoryType->getWithId($data['category_id']);
        $rules->categoryType()->associate($category);
        $rules->save();
        return $rules;
    }
    public function deleteItem($id)
    {
        return $this->model->find($id)->delete();
    }
    public function quizSpecificItem($name)
    {
        $result  = $this->model->with('categoryType')
                        ->whereHas('categoryType',function ($app) use ($name){
                            $app->where('category_name',$name);
                        })
                        ->paginate(15);
        return $result;
    }
    public function updateStatus($data)
    {
        $rules                 =$this->model->find($data);
        $this->model->where('category_id',$rules->category_id)->update(['status'=>0]);
        $rules['status']       = 1;
        $rules->save();
        return $rules;
    }

    public function getActiveRules($name)
    {
        $result = $this->model->with('categoryType')
                 ->whereHas('categoryType',function ($app) use ($name){
                         $app->where('category_name',$name);
                    })->where('status',1)
                    ->first();
        return $result;
    }
    public function rulesCount()
    {
        return $this->model->get()->count();
    }

}
