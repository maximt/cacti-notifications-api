<?php

namespace App\Services\Auth;


class AuthException extends \App\Libs\HttpException
{
    public function __construct($message)
    {
        parent::__construct($message, 401);
    }
}
