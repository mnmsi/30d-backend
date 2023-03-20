<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class BasicRepository
{

    protected $model;

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function getItemWithId($id)
    {
        return $this->model->find($id);
    }

    public function deleteItemWithId($id)
    {
        return $this->model->find($id)->delete();
    }
}
