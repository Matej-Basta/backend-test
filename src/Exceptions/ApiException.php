<?php

namespace Opeepl\BackendTest\Exceptions;

use Exception;

class ApiException extends Exception {

    
    public function __construct($message) {

        parent::__construct($message);

    }

}