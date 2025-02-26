<?php

namespace App\Service;

use App\Dto\LocationDto;
use App\Entity\Profile;
use App\Repository\CountryRepository;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileService
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private CountryService $countryService,
    )
    {

    }

    public function getList()
    {
        return $this->profileRepository->findAllActive();
    }

    public function find(int $id)
    {
        return $this->profileRepository->findProfileById($id);
    }

    public function saveLocation(LocationDto $dto)
    {
        $profile = $this->profileRepository->find($dto->id);
        if ($profile) {
            $profile->setLatitude($dto->latitude);
            $profile->setLongitude($dto->longitude);
            $this->profileRepository->save($profile, true);
        }

        return $profile;
    }

    public function createProfile(array $data)
    {
        $country = $this->countryService->findByCode($data['country'] ?? '');
        $profile = new Profile();
        $profile->setName($data['name']);
        $profile->setSurname($data['surname']);
        $profile->setStatus(1);
        $profile->setEmail($data['email']);
        $profile->setCountry($country);
        $hashedPassword = $this->passwordHasher->hashPassword($profile, $data['password']);
        $profile->setPassword($hashedPassword);

        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile;
    }

}
