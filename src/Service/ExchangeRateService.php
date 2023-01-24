<?php
namespace Opeepl\BackendTest\Service;

use Opeepl\BackendTest\Exceptions\NegativeAmountException;
use Opeepl\BackendTest\Exceptions\UnsupportedCurrencyException;

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

            $data = DataFetcher::fetchData();
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

        // checking, whether the amount is valid
        $this->validateAmount($amount);
        
        $arguments = [
            "amount" => $amount,
            "from" => strtolower($fromCurrency),
            "to" => strtolower($toCurrency),
        ];
        
        /* 
        Prevention for calling the API multiple times if there is an error in a code (for example calling
        the API several times with same values, e.g. because of a wrong implementation of a loop.)
        Checking, whether the parameters are different from the last call, if yes, we fetch new data. If no,
        we return the previous result.
        */
        if ($arguments != $this->last_conversion_values) {

            // if the amount is 0, we do not call the API
            if ($arguments['amount'] === 0) {

                $this->result = 0;

            } elseif ($arguments['from'] === $arguments['to']) { // if the FROM and TO currencies are identical, we don't call the API
            
                $this->result = $arguments['amount'];

            } else {

                $this->last_conversion_values = $arguments;
                $data = DataFetcher::fetchData($arguments);
                var_dump($data);

                if (isset($data["error"])) {
                    throw new UnsupportedCurrencyException($data["error"]["message"]);
                }

                $this->result = round($data['result']);

            }

        }

        return $this->result;

    }


    /**
     * Validating the amount
     * 
     * @param int $amount
     * @throws NegativeAmountException
     */
    private function validateAmount(int $amount) {
        
        if (is_nan($amount) || $amount < 0) {

            throw new NegativeAmountException();

        }

    }

}
