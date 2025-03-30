<?php

namespace App\Exceptions;

class UserNotCreatedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('User not created', 500, null);
    }
}