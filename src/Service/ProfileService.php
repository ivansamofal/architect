<?php

namespace App\Service;

use App\Dto\LocationDto;
use App\Entity\Profile;
use App\Factories\ProfileFactory;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProfileService
{
    public function __construct(
        private readonly ProfileRepository $profileRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly CountryService $countryService,
        private readonly CityService $cityService,
        private readonly SerializerInterface $serializer,
    )
    {

    }

    public function getList(): array
    {
        return $this->profileRepository->findAllActive();
    }

    public function find(int $id): ?Profile
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
        $country = $this->countryService->findByCode($data['countryCode'] ?? '');
        $city = $this->cityService->findById($data['cityId'] ?? 0);
        $birthDate = new \DateTimeImmutable($data['birthDate']);
        $profile = ProfileFactory::create(
            $data['name'],
            $data['surname'],
            $data['email'],
            $country,
            $city,
            $birthDate
        );

        $hashedPassword = $this->passwordHasher->hashPassword($profile, $data['password']);
        $profile->setPassword($hashedPassword);

        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $profile;
    }

}
