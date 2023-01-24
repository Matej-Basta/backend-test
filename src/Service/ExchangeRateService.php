<?php
namespace Opeepl\BackendTest\Service;

use Opeepl\BackendTest\Exceptions\NegativeAmountException;
use Opeepl\BackendTest\Exceptions\UnsupportedCurrencyException;
use Opeepl\BackendTest\Exchanges\Exchange;

/**
 * Main entrypoint for this library.
 */
class ExchangeRateService {

    /**
     * @var array<Exchange>
    */
    private $exchanges;

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

    public function __construct() {

        $this->currencies = [];
        
        $this->exchanges = array(new Exchange("https://api.apilayer.com/exchangerates_data/symbols", "https://api.apilayer.com/exchangerates_data/convert?to=placeholderTo&from=placeholderFrom&amount=placeholderAmount", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM"));
        
        // here, we can easily switch to a different default exchange API, the commented line below is an example

        // $this->exchanges = array(new Exchange("https://api.apilayer.com/currency_data/list", "https://api.apilayer.com/currency_data/convert?to=placeholderTo&from=placeholderFrom&amount=placeholderAmount", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM"));

    }

    /**
     * Changing to another exchange rate API
     *
     * @param string $url_currencies
     * @param string $url_converter
     * @param string $key
     */
    public function setExchange(string $url_currencies, string $url_converter, string $key) {
        
        $this->exchanges = array();
        $this->currencies = array();
        array_push($this->exchanges, new Exchange($url_currencies, $url_converter, $key));

    }

    /**
     * Adding another exchange rate API
     *
     * @param string $url_currencies
     * @param string $url_converter
     * @param string $key
     */
    public function addExchange(string $url_currencies, string $url_converter, string $key) {
        
        $this->currencies = [];
        array_push($this->exchanges, new Exchange($url_currencies, $url_converter, $key));

    }


    /**
     * Return all supported currencies
     *
     * @return array<string>
     */
    public function getSupportedCurrencies(): array {

        /* Checking whether we have already fetched the currencies. If we have't, we fetch them and store them into
        a class property, so we do not have to call the API again. If we have, we will simply return the property.
        */
        if (empty($this->currencies)) {

            foreach ($this->exchanges as $exchange) {

                $symbols = $exchange->getCurrencies();

                foreach ($symbols as $symbol) {

                    // inluding the symbol, only if it is not already included from different API
                    if (!in_array($symbol, $this->currencies)) {
                        array_push($this->currencies, $symbol);
                    }

                }

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

        // checking, whether the currencies are supported, but only if the currencies class property is set
        $this->validateCurrency($fromCurrency);
        $this->validateCurrency($toCurrency);
        
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

                $this->result = $this->exchanges[0]->getAmount($amount, $fromCurrency, $toCurrency);

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

    /**
     * Validating the currency
     * 
     * @param string $currency
     * @throws UnsupportedCurrencyException
     */
    private function validateCurrency(string $currency) {

        if (!empty($this->currencies)) {

            if (!in_array(strtoupper($currency), $this->currencies)) {
                throw new UnsupportedCurrencyException("$currency is not a supported currency.");
            }

        }

    }

}
