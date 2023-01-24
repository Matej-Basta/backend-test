<?php

namespace Opeepl\BackendTest;

require_once './Service/ExchangeRateService.php';
require_once './Exceptions/NegativeAmountException.php';
require_once './Exceptions/UnsupportedCurrencyException.php';
require_once './Service/DataFetcher.php';

use Opeepl\BackendTest\Service\ExchangeRateService;

$exchange_rate_service = new ExchangeRateService();

echo $exchange_rate_service->getExchangeAmount(89, 'dkk', 'rara');
