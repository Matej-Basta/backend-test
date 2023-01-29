<?php
namespace Opeepl\BackendTest\Service;

use Opeepl\BackendTest\Service\DataFetcher;
use Opeepl\BackendTest\Exceptions\UnsupportedCurrencyException;

class Exchange {
    
    /**
     * @var string
    */
    private $url_currencies;

    /**
     * @var string
    */
    private $url_converter;

    /**
     * @var string
    */
    private $key;

    public function __construct(string $url_currencies, string $url_converter, string $key) {
        
        $this->url_currencies = $url_currencies;
        $this->url_converter = $url_converter;
        $this->key = $key;
    }
    
    /**
     * @return array<string>
     */
    public function getCurrencies() : array {

        $data = DataFetcher::fetchData($this->url_currencies, $this->key);

        // will work only with APIs, that return the symbols with a key "symbols" or "currencies"
        if (isset($data["symbols"])) {

            return array_keys($data["symbols"]);

        } elseif (isset($data["currencies"])) {

            return array_keys($data["currencies"]);

        }

    }

    /**
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     */
    public function getAmount(int $amount, string $fromCurrency, string $toCurrency) : int {
        
        
        // creating the url with correct parameters
        $this->url_converter = $this->createCorrectURL($amount, $fromCurrency, $toCurrency);

        $data = DataFetcher::fetchData($this->url_converter, $this->key);

        if (isset($data["error"])) {

            if (isset($data["error"]["message"])) {
                throw new UnsupportedCurrencyException($data["error"]["message"]);
            } elseif (isset($data["error"]["info"])) {
                throw new UnsupportedCurrencyException($data["error"]["info"]);
            }
        }

        $result = round($data['result']);
        
        return $result;

    }

    private function createCorrectURL(int $amount, string $fromCurrency, string $toCurrency) {
        $search = array("placeholderTo", "placeholderFrom", "placeholderAmount");
        $replace = array($toCurrency, $fromCurrency, $amount);
        return str_replace($search, $replace, $this->url_converter);
    }

}