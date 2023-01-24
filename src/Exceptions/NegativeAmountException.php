<?php
namespace Opeepl\BackendTest\Exceptions;

use Exception;

class NegativeAmountException extends Exception {

    public function __construct() {
        $message = "Amount value is not valid. It must be an integer greater than or equal to zero.";
        parent::__construct($message);
    }

}