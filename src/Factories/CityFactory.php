<?php

namespace App\Factories;

use App\Entity\City;
use App\Entity\Country;

class CityFactory
{
    public static function create(string $name, Country $country, int $population): City
    {
        $entity = new City();
        $entity->setName($name);
        $entity->setCountry($country);
        $entity->setPopulation($population);
        $entity->setActive(true);

        return $entity;
    }
}
