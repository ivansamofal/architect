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
        $city = $this->cityRepository->find($id);

        if (null === $city) {
            throw new \Exception('City not found');
        }

        return $city;
    }

    public function findByName(string $name)
    {
        return $this->cityRepository->findOneBy(['name' => $name]);
    }

    public function saveAll(array $cities, bool $flush = false): void
    {
        $this->cityRepository->saveAll($cities, true);
    }
}
