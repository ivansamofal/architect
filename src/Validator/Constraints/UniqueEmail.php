<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class UniqueEmail extends Constraint
{
    public string $message = 'Email "{{ value }}" already exists.';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
