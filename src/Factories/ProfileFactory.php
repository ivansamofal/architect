<?php

namespace App\Factories;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Profile;

class ProfileFactory
{
    public static function create(
        string $name,
        string $surname,
        string $email,
        Country $country,
        City $city,
        \DateTimeInterface $birthDate
    ): Profile
    {
        $profile = new Profile();
        $profile->setName($name);
        $profile->setSurname($surname);
        $profile->setStatus(1);
        $profile->setEmail($email);
        $profile->setCountry($country);
        $profile->setCity($city);
        $profile->setBirthDate($birthDate);
        $profile->setPassword($password);

        return $profile;
    }
}
