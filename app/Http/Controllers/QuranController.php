<?php

namespace App\Http\Controllers;

use App\Http\Resources\Quran\QuranDataFormatForPagination;
use App\Http\Resources\Quran\QuranDataFormatResource;
use App\Repositories\Quran\QuranRepositoryInterface;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class QuranController extends Controller
{

    /**
     * @var QuranRepositoryInterface
     */
    private $quranUlKarim;

    public function __construct(QuranRepositoryInterface $quranRepository)
    {
        $this->quranUlKarim = $quranRepository;
    }

    public function getListOfQuranChapter(Request $request)
    {
        $lang = $request->lang;
        try {
            $chapter = $this->quranUlKarim->QuranUlKarimChapter($lang);
            return ['status'=>1,'data'=>json_decode($chapter)];
        }
        catch (\Exception $e)
        {
            return [ 'status'=>0,'message'=>'Something went wrong Try again letter'];
        }
    }

    public function getSpecificChapter(Request $request)
    {
        $chapterId = $request->chapterId;
        $page = $request->page;
        $amount = $request->amount;
        $result = $this->quranUlKarim->getSpecificChapter($chapterId,$page,$amount);
        $data =  QuranDataFormatResource::collection($result['verses']);
        $pagination =   new QuranDataFormatForPagination($result['pagination']);
        return ['status'=>1,'data'=>$data,'pagination'=>$pagination];
    }
}
