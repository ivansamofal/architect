<?php

namespace App\Service;

use App\Entity\Country;
use App\Repository\CountryRepository;

readonly class CountryService
{
    public function __construct(private CountryRepository $countryRepository)
    {

    }

    public function findById(int $id): ?Country
    {
        return $this->countryRepository->find($id);
    }

    public function findByCode(string $code, int $length = 2)
    {
        $column = 2 === $length ? 'alpha2' : 'alpha3';
        $country = $this->countryRepository->findOneBy([$column => strtoupper($code)]);

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
