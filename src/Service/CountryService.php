<?php

namespace App\Service;

use App\Repository\CountryRepository;
use App\Repository\ProfileRepository;

class CountryService
{
    public function __construct(private CountryRepository $countryRepository)
    {

    }

    public function findById(int $id)
    {
        return $this->countryRepository->find($id);
    }

    public function findByCode(string $code, int $length = 2)
    {
        $column = $length === 2 ? 'alpha2' : 'alpha3';
        $country = $this->countryRepository->findOneBy([$column => $code]);

        if (!$country) {
            throw new \Exception('Country not found');
        }

        return $country;
    }

    public function saveAll(array $countries, bool $flush = false): void
    {
        $this->countryRepository->saveAll($countries, true);
    }
}
