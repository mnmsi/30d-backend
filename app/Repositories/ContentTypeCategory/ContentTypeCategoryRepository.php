<?php


namespace App\Repositories\ContentTypeCategory;


use App\Repositories\ContentType\ContentTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ContentTypeCategoryRepository extends \App\Repositories\BasicRepository implements ContentTypeCategoryRepositoryInterface
{
    /**
     * @var ContentTypeRepositoryInterface
     */
    private $type;

    public function __construct(Model $model, ContentTypeRepositoryInterface $contentTypeRepository)
    {
        parent::__construct($model);
        $this->type = $contentTypeRepository;
    }

    public function insert($data)
    {
        $type = $this->type->findData($data->contentType);
        $value = $this->model;
        $value['category_name'] = $data->name;
        $value->contentType()->associate($type);
        $value->save();

        return ['status'=>1,'data'=>$value];
    }

    public function getCategoryList($type)
    {
        $lifestyle = $this->type->getType($type);

        return $this->model->where('content_type_id',$lifestyle->id)->get();
    }

    public function getWithId($id)
    {
        return $this->model->find($id);
    }
}
