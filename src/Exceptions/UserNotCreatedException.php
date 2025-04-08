<?php

namespace App\Exceptions;

class UserNotCreatedException extends \Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?: 'User not created', 500, null);
    }
}
