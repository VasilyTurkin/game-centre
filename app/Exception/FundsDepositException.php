<?php

namespace App\Exception;

use Exception;

class FundsDepositException extends Exception
{
    public function __construct()
    {
        parent::__construct("Не достаточно средств");
    }
}
