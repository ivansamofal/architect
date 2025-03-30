<?php

namespace App\Exceptions;

class ReviewNotCreatedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Review not created', 500, null);
    }
}