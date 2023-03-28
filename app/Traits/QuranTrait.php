<?php

namespace App\Traits;

trait QuranTrait
{
    public function getQuranData()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.alquran.cloud/v1/quran',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function getQuranDataEn()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.alquran.cloud/v1/quran/en.asad',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function getAllAyahData($data, $data_en)
    {
        if (count($data) == 0) return $data;

        $new_data = array();
        foreach ($data as $k => $sura) {
            foreach ($sura['ayahs'] as $s => $ayah) {
                $new_data[] = [
                    'ayah_id' => $ayah['number'],
                    'page' => $ayah['page'],
                    'para' => $ayah['juz'],
                    'sajda' => $ayah['sajda'],
                    'ayah_text' => [
                        'en' => $data_en['data']['surahs'][$k]['ayahs'][$s]['text'],
                        'ar' => $ayah['text']
                    ],
                    'sura' => [
                        'id' => $sura['number'],
                        'en' => $sura['englishName'],
                        'ar' => $sura['name'],
                    ],
                    'audio' => $this->getStaticReciter($ayah['number'])
                ];
            }
        }
        return $new_data;
    }

    public function getStaticReciter($ayah)
    {
        return [
            [
                "name" => "Abdul Basit",
                "image" => url('/reciter/abdul_basit.jpg'),
                "language" => "ar",
                "audio" => 'https://cdn.islamic.network/quran/audio/192/ar.abdulbasitmurattal/' . $ayah . '.mp3'
            ],
            [
                "name" => "Abdul Samad",
                "image" => url('/reciter/abdul_basit.jpg'),
                "language" => "ar",
                "audio" => 'https://cdn.islamic.network/quran/audio/64/ar.abdulsamad/' . $ayah . '.mp3'
            ],
            [
                "name" => "Alafasy",
                "image" => url('/reciter/alafasy.jpg'),
                "language" => "ar",
                "audio" => 'https://cdn.islamic.network/quran/audio/128/ar.alafasy/' . $ayah . '.mp3'
            ],
        ];
    }

    public function getReciter($surah, $ayah, $size = '192')
    {
        return [
            [
                "name" => "Abdul Basit",
                "audio" => $this->getAudioByName($surah, $ayah, 'ar.abdulbasitmurattal')['audio']
            ],
            [
                "name" => "Abdul Samad",
                "audio" => $this->getAudioByName($surah, $ayah, 'ar.abdulsamad')['audio']
            ],
            [
                "name" => "Alafasy",
                "audio" => $this->getAudioByName($surah, $ayah, 'ar.alafasy')['audio']
            ],
        ];
    }

    public function getAudioByName($surah, $ayah, $name)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.alquran.cloud/v1/surah/' . $surah . '/' . $name,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $final = json_decode($response, true);

        $search = array_search($ayah, array_column($final['data']['ayahs'], 'number'));

        return $final['data']['ayahs'][$search];
    }

    public function getSuraDetailsWithAyah($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.alquran.cloud/v1/surah/' . $id . '/editions/quran-uthmani,en.asad',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function singleAyahDetailsById($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.alquran.cloud/v1/ayah/' . $id . '/editions/quran-uthmani,en.asad',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function getArabicCalender($m,$y)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.aladhan.com/v1/gToHCalendar/'. $m .'/' . $y,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
}
