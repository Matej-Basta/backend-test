<?php
namespace Opeepl\BackendTest\Exchanges;

abstract class ExchangeClass {
    
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
    abstract public function getCurrencies() : array;

    /**
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     */
    abstract public function getConvertedAmount(int $amount, string $fromCurrency, string $toCurrency) : int;

}