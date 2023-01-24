<?php

namespace Opeepl\BackendTest\Exceptions;

use Exception;

class UnsupportedCurrencyException extends Exception {

    
    public function __construct($message) {

        parent::__construct($message);

    }

}