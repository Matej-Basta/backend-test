<?php

namespace Opeepl\BackendTest\Service;

require_once './Service/ExchangeRateService.php';

$exchange_rate_service = new ExchangeRateService();

echo $exchange_rate_service->getSupportedCurrencies();

echo "ahoj";

echo $exchange_rate_service->getSupportedCurrencies();
