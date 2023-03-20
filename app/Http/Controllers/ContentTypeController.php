<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Http\Request;
use App\Repositories\Content\ContentRepository;

class ContentTypeController extends Controller
{


    public function index()
    {
        return view('Content.index');
    }

    public function contentCreatePageShow()
    {
        return view('Content.lifeStyle-create-page');
    }

    public function insert(Request $request)
    {
        $value = new ContentType();
        $value['content_type'] = $request->name;
        $value->save();
        return ['status'=>1,'data'=>$value];
    }
}
