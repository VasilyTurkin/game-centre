<?php

namespace App\Exceptions;

use Exception;

class DepositLimitException extends Exception
{
    public function __construct($limit)
    {
        parent::__construct("Превышен лимит пополнения. Разрешено внести $limit");
    }
}
