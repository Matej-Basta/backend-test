<?php

namespace Opeepl\BackendTest\Service;

use Opeepl\BackendTest\Exceptions\ApiException;

class DataFetcher {

    public static function fetchData(string $url, string $key): array {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: " . $key,
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

        if (!isset($data['success'])) {
            throw new ApiException("The API is not responding. It might be caused by an error on the API provider's side, or you might have entered a wrong URL or API key.");
        }

        return $data;

    }

}