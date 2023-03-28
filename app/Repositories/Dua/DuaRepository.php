<?php

namespace App\Repositories\Dua;

use App\Models\DuasCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function createDuaItems($data, $id = null)
    {
        if ($id) {
            $item = $this->duaCat->find($id);
        } else {
            $item = $this->duaCat;
        }

        $item->title = $data['title'];
        $item->ar_text = $data['content_ar'];
        $item->en_text = $data['content_en'];
        if (array_key_exists('file', $data)) {
            $item->audio = $data['file']->store('dua', 'public');;
        }
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

    public function getDuaItem($id)
    {
        return $this->duaCat->find($id);
    }

    public function totalDuaItems()
    {
        return $this->duaCat->get()->count();
    }

    public function duaWithCategory()
    {
        return $this->model->with('category')
            ->withCount('category')
            ->where('status', 1)
            ->havingRaw('category_count > 0')
            ->get();
    }
}
