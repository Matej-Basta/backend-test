<?php
namespace Opeepl\BackendTest\Service;

/**
 * Main entrypoint for this library.
 */
class ExchangeRateService {

    /**
     * @var array<string> 
    */
    private $currencies;


    /**
     * Return all supported currencies
     *
     * @return array<string>
     */
    public function getSupportedCurrencies(): array {

        if (isset($this->currencies)) {
        } else {
        }

        $data = $this->fetchData();

        $data_keys = [];

        foreach($data["symbols"] as $key => $value) {
            array_push($data_keys, $key);
        }

        return $data_keys;

    }

    /**
     * Given the $amount in $fromCurrency, it returns the corresponding amount in $toCurrency.
     *
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     */
    public function getExchangeAmount(int $amount, string $fromCurrency, string $toCurrency): int {

        $arguments = [
            "amount" => $amount,
            "from" => $fromCurrency,
            "to" => $toCurrency,
        ];
        
        $data = $this->fetchData($arguments);

        $result = round($data['result']);

        echo $result;

        return $result;

    }

    private function fetchData(array $parameters = []): array {
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
