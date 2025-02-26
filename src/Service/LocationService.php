<?php

namespace App\Service;

use App\Repository\ProfileRepository;

class LocationService
{
    public function __construct(private ProfileRepository $profileRepository)
    {

    }

    public function getList()
    {
        $list = $this->profileRepository->findAllActive();

        return $list;
    }

    public function find(int $id)
    {
        return $this->profileRepository->find($id);
    }
}
