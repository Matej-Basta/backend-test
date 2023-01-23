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
     * @var array<string> 
    */
    private $last_conversion_values;

    /**
     * @var int 
    */
    private $result;


    /**
     * Return all supported currencies
     *
     * @return array<string>
     */
    public function getSupportedCurrencies(): array {

        /* Checking whether we have already fetched the currencies. If we have't, we fetch them and store them into
        a class property, so we do not have to call the API again. If we have, we will simply return the property.
        */
        if (!isset($this->currencies)) {

            $data = $this->fetchData();
            $this->currencies = [];
            foreach($data["symbols"] as $key => $value) {
                array_push($this->currencies, $key);
            }
        } 

        return $this->currencies;

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

        
        /* 
        Prevention for calling the API multiple times if there is an error in a code (for example calling
        the API several times with same values, e.g. because of a wrong implementation of a loop.)
        Checking, whether the parameters are different from the last call, if yes, we fetch new data. If no,
        we return the previous result.
        */
        if ($arguments != $this->last_conversion_values) {
            $this->last_conversion_values = $arguments;
            $data = $this->fetchData($arguments);
            $this->result = round($data['result']);
        }

        return $this->result;

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
