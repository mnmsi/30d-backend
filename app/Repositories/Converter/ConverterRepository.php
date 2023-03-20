<?php


namespace App\Repositories\Converter;


class ConverterRepository implements ConverterRepositoryInterface
{

    public function metalPriceGetFromApi()
    {
        $url = "https://www.metals-api.com/api/latest?access_key=t8fnolzcp7c7c6qllso4hn2c5fnd390emvz8yaxuw74es22a6d6s1d7fr18i&base=GBP&symbols=XAU,XAG";
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
