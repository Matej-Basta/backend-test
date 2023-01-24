<?php

namespace Opeepl\BackendTest\Service;

class DataFetcher
{

    public static function fetchData(array $parameters = []): array {
        $curl = curl_init();

        $url = "";

        if (empty($parameters)) {

            $url = "https://api.apilayer.com/exchangerates_data/symbols";

        } else {

            $url = "https://api.apilayer.com/exchangerates_data/convert?to={$parameters["to"]}&from={$parameters["from"]}&amount={$parameters["amount"]}";
        
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response, true);

        return $data;
    }

}