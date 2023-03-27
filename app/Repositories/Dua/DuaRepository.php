<?php

namespace App\Repositories\Dua;

use App\Models\DuasCategory;
use Illuminate\Database\Eloquent\Model;

class DuaRepository extends \App\Repositories\BasicRepository implements DuaRepositoryInterface
{
    private $duaCat;

    public function __construct(Model $model, DuasCategory $duasCategory)
    {
        parent::__construct($model);
        $this->duaCat = $duasCategory;
    }

    public function getDua()
    {
        return $this->model->select('id', 'title')->where('status', 1)->get();
    }

    public function createDua($data)
    {
        $dua = $this->model;
        $dua->title = $data['title'];
        $dua->sub_title = $data['description'];
        $dua->image = $data['image']->store('dua', 'public');
        $dua->save();
        return $dua;
    }

    public function createDuaItems($data)
    {
        $item = $this->duaCat;
        $item->title = $data['title'];
        $item->ar_text = $data['content_ar'];
        $item->en_text = $data['content_en'];
        $item->audio = $data['file']->store('dua', 'public');;
        $category = $this->model->find($data['category']);
        $item->dua()->associate($category);
        $item->save();
        return $item;
    }

    public function getCategoryData($id = null)
    {
        return $this->duaCat->with('dua')
            ->when($id, function ($d) use ($id) {
                $d->where('dua_id', $id);
            })
            ->paginate(15);
    }
}
