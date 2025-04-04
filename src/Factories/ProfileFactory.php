<?php

namespace App\Factories;

use App\Dto\ProfileDto;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Profile;

class ProfileFactory
{
    public static function create(
        ProfileDto $profileDto,
        Country $country,
        City $city
    ): Profile
    {
        $profile = new Profile();
        $profile->setName($profileDto->name);
        $profile->setSurname($profileDto->surname);
        $profile->setStatus(1);
        $profile->setEmail($profileDto->email);
        $profile->setCountry($country);
        $profile->setCity($city);
        $profile->setBirthDate($profileDto->birthDate);

        return $profile;
    }
}
