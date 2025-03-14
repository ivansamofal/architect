<?php

namespace App\Factories;

use App\Entity\Country;

class CountryFactory
{
    public static function create(string $name, string $code2, string $code3): Country
    {
        $entity = new Country();
        $entity->setName($name);
        $entity->setAlpha2($code2);
        $entity->setAlpha3($code3);

        return $entity;
    }
}
