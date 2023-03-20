<?php

namespace App\Repositories\NewsPortal;

use App\Repositories\BasicRepository;
use App\Repositories\Content\ContentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NewsPortalRepository extends BasicRepository implements NewsPortalRepositoryInterface
{
    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepo;

    public function __construct(Model $model, ContentRepositoryInterface $contentRepo)
    {
        parent::__construct($model);
        $this->contentRepo = $contentRepo;
    }

    public function getNewsList()
    {
        return $this->model
            ->OrderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function createNews($data)
    {
        $newsPortal                      = $this->model;
        $newsPortal['title']             = $data['title'];
        $newsPortal['short_description'] = $data['short_description'];
        $newsPortal['content']           = $this->contentRepo->convertFile($data);
        $newsPortal['featured_image']    = $data['image']->store('content', 'public');
        $newsPortal['created_at']        = now();

        if (!empty($data['video_url'])) {
            $newsPortal['video_url'] = $data['video_url'];
        }

        $newsPortal->save();
        return $newsPortal;
    }

    public function updateNews($data)
    {
        $newsPortal                      = $this->model->find($data['id']);
        $newsPortal['title']             = $data['title'];
        $newsPortal['short_description'] = $data['short_description'];
        $newsPortal['content']           = $this->contentRepo->convertFile($data);

        if (isset($data['video_url'])) {
            $newsPortal['video_url'] = $data['video_url'];
        }

        if (isset($data['image'])) {
            Storage::disk('public')->delete($data['image']);
            $newsPortal['featured_image'] = $data['image']->store('content', 'public');
        }

        $newsPortal->save();
        return $newsPortal;
    }

    public function getSingleItem($id)
    {
        $data =  $this->model
            ->where('id', $id)
            ->first();
        $data['content'] = $this->contentRepo->postProccessing($data['content']);
        return $data;
    }

    public function deleteItem($id)
    {
        return $this->model->find($id)->delete();
    }

    public function newsCount()
    {
        return $this->model->get()->count();
    }
}
