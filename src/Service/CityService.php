<?php

namespace App\Service;

use App\Repository\CityRepository;

class CityService
{
    public function __construct(private readonly CityRepository $cityRepository)
    {

    }

    public function findById(int $id)
    {
        return $this->cityRepository->find($id);
    }

    public function findByName(string $name)
    {
        return $this->cityRepository->findOneBy(['name' => $name]);
    }
}
