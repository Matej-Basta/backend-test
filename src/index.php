<?php

namespace Opeepl\BackendTest\Service;

require_once './Service/ExchangeRateService.php';

$exchange_rate_service = new ExchangeRateService();

$exchange_rate_service->getSupportedCurrencies();