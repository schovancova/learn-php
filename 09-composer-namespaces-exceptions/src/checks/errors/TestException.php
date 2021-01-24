<?php
namespace main\checks\errors;

use Exception;

class TestException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    public function customFunction() {
        echo "A custom function for this type of exception\n";
    }
}