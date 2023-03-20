<?php


namespace App\Repositories\Namaz;


class NamazRepository implements NamazRepositoryInterface
{

    public function prayerTimeForSpecificDay($month, $year, $lat, $lan)
    {
        $lat = $lat ?? "51.3419134";
        $lan = $lan ?? "11.821668";

        $url = "http://api.aladhan.com/v1/calendar?latitude=" . $lat . "&longitude=" . $lan . "&method=1&month=" . $month . "&year=" . $year . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);  //if you need
        curl_close($ch);
        return json_decode($response);
    }


    public function  ramadanCalender($year)
    {
        $url = "http://api.aladhan.com/v1/hijriCalendarByCity?city=Dhaka&country=Bangladesh&method=2&month=09&year=" . $year . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);  //if you need
        curl_close($ch);
        return json_decode($response);

    }
}
