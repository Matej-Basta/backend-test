<?php
namespace Opeepl\BackendTest\Exchanges;

class ExchangeRatesDataAPI extends ExchangeClass {

    public function __construct(string $url_currencies, string $url_converter, string $key) {
        parent::__construct($url_currencies, $url_converter, $key);
    }

}