<?php


namespace App\Repositories\Quran;


class QuranRepository implements QuranRepositoryInterface
{


    public function QuranUlKarimChapter($lang)
    {

        $lang = $lang ?? "en";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.quran.com/api/v4/chapters?language=" . $lang . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function getSpecificChapter($id, $page, $amount)
    {
        $arabic =  $this->chapterWithArabicVerse($id, $page, $amount);
        return json_decode($arabic, true);
    }
    protected function chapterWithArabicVerse($id, $page, $amount)
    {
        $curl = curl_init();
        $url = "https://api.quran.com/api/v4/verses/by_chapter/" . $id . "?language=en&words=false&translations=213&fields=text_uthmani&page=" . $page . "&per_page=" . $amount . "&audio=7";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
