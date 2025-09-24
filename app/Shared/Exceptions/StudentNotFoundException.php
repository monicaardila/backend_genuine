<?php

namespace App\Shared\Exceptions;

use Exception;

class StudentNotFoundException extends Exception
{
    public function __construct(string $message = "Student not found", int $code = 404, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
