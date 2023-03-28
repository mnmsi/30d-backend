<?php

namespace App\Http\Controllers;

use App\Http\Resources\DuaResource;
use App\Repositories\Dua\DuaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DuaController extends Controller
{
    private $duaRepo;

    public function __construct(DuaRepositoryInterface $duaRepository)
    {
        $this->duaRepo = $duaRepository;
    }

    public function index()
    {
        $dua = $this->duaRepo->getDua();
        $content = $this->duaRepo->getCategoryData();
        return view('dua.index', ['dua' => $dua, 'content' => $content]);
    }

    public function searchIndex(Request $request, $id)
    {
        $dua = $this->duaRepo->getDua();
        $content = $this->duaRepo->getCategoryData($id);
        return view('dua.index', ['dua' => $dua, 'content' => $content]);
    }

    public function add()
    {
        return view('dua.add');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|mimes:jpeg,jpg,png,svg|max:5000'
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            $result = $this->duaRepo->createDua($request->all());
            return redirect()->route('dua')->with('message', 'Dua Added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong,Please try again letter');
        }

    }

    public function addItem(Request $request)
    {
        $dua = $this->duaRepo->getDua();
        return view('dua.addItem', ['dua' => $dua]);
    }

    public function storeItem(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'content_en' => 'required|string',
                'content_ar' => 'required|string',
                'category' => 'required|exists:App\Models\Duas,id',
                'file' => 'required|max:500000'
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            $result = $this->duaRepo->createDuaItems($request->all());
            return redirect()->route('dua')->with('message', 'Dua item Added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong,Please try again letter');
        }
    }

    public function deleteItem(Request $request, $id)
    {
        $item = $this->duaRepo->getDuaItem($id);
        $item->delete();
        return redirect()->back()->with('message', 'Item delete successfully');
    }

    public function editItem(Request $request, $id)
    {
        $dua = $this->duaRepo->getDua();
        $item = $this->duaRepo->getDuaItem($id);

        return view('dua.editItem', ['dua' => $dua, 'item' => $item]);
    }

    public function updateItem(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'content_en' => 'required|string',
                'content_ar' => 'required|string',
                'category' => 'required|exists:App\Models\Duas,id',
                'file' => 'nullable|max:500000'
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
            $result = $this->duaRepo->createDuaItems($request->all(),$id);
            return redirect()->route('dua')->with('message', 'Dua item Added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong,Please try again letter');
        }
    }

    public function getAllDuaWithCategory()
    {
        return [
            'status' => 1,
            'data' => DuaResource::collection($this->duaRepo->duaWithCategory())
        ];
    }
}
