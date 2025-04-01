<?php

namespace App\Service;

use App\Dto\LocationDto;
use App\Entity\Profile;
use App\Event\ProfileEvent;
use App\Exceptions\UserNotCreatedException;
use App\Factories\ProfileFactory;
use App\Repository\ProfileRepository;
use App\Service\Interfaces\ProfileServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        private readonly ProfileRepository $profileRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly CountryService $countryService,
        private readonly CityService $cityService,
        private readonly TagAwareCacheInterface $cache,
        private readonly LoggerInterface $logger,
        private readonly EventDispatcherInterface $eventDispatcher,
    )
    {

    }

    public function getList(): array
    {
        return $this->cache->get('profiles.list', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            $item->tag(['profiles']);

            return $this->profileRepository->findAllActive();
        });
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

    public function createProfile(array $data): Profile
    {
        try {
            if (empty($data['email'])) {
                throw new \Exception('email is required');
            }

            $profile = $this->profileRepository->findBy(['email' => $data['email']]);

            if ($profile) {
                throw new \Exception('profile already exists with this email');
            }

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
            $this->cache->invalidateTags(['profiles']);

            $event = new ProfileEvent($profile->getId(), $profile->getEmail());
            $this->eventDispatcher->dispatch($event, ProfileEvent::NAME);

            return $profile;
        } catch (\Throwable $e) {
            $this->logger->error('User creation failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw new UserNotCreatedException($e->getMessage());
        }
    }
}
