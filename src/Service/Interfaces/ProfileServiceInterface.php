<?php
namespace App\Service\Interfaces;

use App\Dto\LocationDto;
use App\Dto\ProfileDto;
use App\Entity\Profile;

interface ProfileServiceInterface
{
    public function getList(): array;

    public function find(int $id): ?Profile;

    public function saveLocation(LocationDto $dto);

    public function createProfile(ProfileDto $profileDto): Profile;
}
