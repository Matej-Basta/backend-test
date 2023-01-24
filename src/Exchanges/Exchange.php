<?php
namespace Opeepl\BackendTest\Exchanges;

use Opeepl\BackendTest\Service\DataFetcher;

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
    public function getConvertedAmount(int $amount, string $fromCurrency, string $toCurrency) : int {
        
        
        // creating the url with correct parameters
        $search = array("placeholderTo", "placeholderFrom", "placeholderAmount");
        $replace = array($toCurrency, $toCurrency, $amount);
        $url_converter = str_replace($search, $replace, $url_converter);

        $result = DataFetcher::getchData($this->url_converter, $this->key);
        return $result;

    }

}