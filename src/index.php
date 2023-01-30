<?php

namespace Opeepl\BackendTest;

require_once './Service/ExchangeRateService.php';
require_once './Exceptions/NegativeAmountException.php';
require_once './Exceptions/UnsupportedCurrencyException.php';
require_once './Exceptions/ApiException.php';
require_once './Service/DataFetcher.php';
require_once './Service/Exchange.php';

use Opeepl\BackendTest\Service\ExchangeRateService;

$exchange_rate_service = new ExchangeRateService();

// $exchange_rate_service->addExchange("https://api.apilayer.com/currency_data/list", "https://api.apilayer.com/currency_data/convert?to=placeholderTo&from=placeholderFrom&amount=placeholderAmount", "tTmluFD1qzf5NvfHV8fbn7FB4pDimE92");

echo $exchange_rate_service->getExchangeAmount(100, "HAHA", "DKK");
// echo $exchange_rate_service->getSupportedCurrencies();

