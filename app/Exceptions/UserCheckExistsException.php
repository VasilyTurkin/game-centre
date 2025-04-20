<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class UserCheckExistsException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (empty($message)) {
            $message = "Пользователь с таким email или login уже существует";
        }
        parent::__construct($message, $code, $previous);
    }
}
