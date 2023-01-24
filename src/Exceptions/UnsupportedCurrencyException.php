<?php

namespace Opeepl\BackendTest\Exceptions;

use Exception;

class UnsupportedCurrencyException extends Exception {

    
    public function __construct($currency) {

        $message = "The currency $currency is not supported.";
        parent::__construct($message);

    }

}