<?php

namespace App\Shared\Exceptions;

use Exception;

class StudentEmailAlreadyExistsException extends Exception
{
    public function __construct(string $message = "Student email already exists", int $code = 422, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
