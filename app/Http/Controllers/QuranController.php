<?php

namespace App\Http\Controllers;

use App\Http\Resources\Quran\QuranDataFormatForPagination;
use App\Http\Resources\Quran\QuranDataFormatResource;
use App\Repositories\Quran\QuranRepositoryInterface;
use App\Traits\QuranTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class QuranController extends Controller
{
    use QuranTrait;

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
            return ['status' => 1, 'data' => json_decode($chapter)];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'Something went wrong Try again letter'];
        }
    }

    public function getSpecificChapter(Request $request)
    {
        $chapterId = $request->chapterId;
        $page = $request->page;
        $amount = $request->amount;
        $result = $this->quranUlKarim->getSpecificChapter($chapterId, $page, $amount);
        $data = QuranDataFormatResource::collection($result['verses']);
        $pagination = new QuranDataFormatForPagination($result['pagination']);
        return [
            'status' => 1,
            'data' => $data,
            'pagination' => $pagination
        ];
    }

    /**
     *
     * v2 quran api
     *
     */

    public function getAllAyah()
    {
        try {
            $quran_data = $this->getQuranData();
            $quran_data_en = $this->getQuranDataEn();

            if ($quran_data['status'] == "OK") {
                return [
                    'status' => 1,
                    'data' => $this->getAllAyahData($quran_data['data']['surahs'], $quran_data_en),
                ];
            }
            return [
                'status' => 0,
                'errors' => "Something went wrong"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 0,
                'errors' => $e->getMessage()
            ];
        }
    }

//    public function getDetails()
//    {
//        return $this->getAudioByName(1, 3, 'ar.abdulbasitmurattal');
//    }

    public function getAllAyahBySuraData(Request $request)
    {
//        ini_set('max_execution_time', -1);
        $data = $this->getSuraDetailsWithAyah($request->id);
        $result = array();

        foreach ($data['data'][0]['ayahs'] as $k => $ayah) {
            $result[] = [
                'ayah_id' => $ayah['number'],
                'page' => $ayah['page'],
                'para' => $ayah['juz'],
                'sajda' => $ayah['sajda'],
                'ayah_text' => [
                    'ar' => $ayah['text'],
                    'en' => $data['data'][1]['ayahs'][$k]['text']
                ],
                'sura' => [
                    'id' => $data['data'][0]['number'],
                    'en' => $data['data'][0]['englishName'],
                    'ar' => $data['data'][0]['name']
                ],
                'audio' => $this->getReciter($data['data'][0]['number'], $ayah['number'])
            ];
        }
        return $result;
    }

    public function getSingleAyahDetailsByIdRange(Request $request)
    {
        $result = array();

        for ($request->from; $request->from <= $request->to; $request->from++) {
            $data = $this->singleAyahDetailsById($request->from);
            $ayah = $data['data'];
            $result[] = [
                'ayah_id' => $ayah[0]['number'],
                'page' => $ayah[0]['page'],
                'para' => $ayah[0]['juz'],
                'sajda' => $ayah[0]['sajda'],
                'ayah_text' => [
                    'ar' => $ayah[0]['text'],
                    'en' => $ayah[1]['text']
                ],
                'sura' => [
                    'id' => $ayah[0]['surah']['number'],
                    'en' => $ayah[0]['surah']['englishName'],
                    'ar' => $ayah[0]['surah']['name']
                ],
                'audio' => $this->getReciter($ayah[0]['surah']['number'], $ayah[0]['number'])
            ];
        }
        return $result;
    }
}
