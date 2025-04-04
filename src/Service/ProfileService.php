<?php

namespace App\Service;

use App\Dto\LocationDto;
use App\Dto\ProfileDto;
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

    public function createProfile(ProfileDto $profileDto): Profile
    {
        try {
            $profile = $this->prepareEntity($profileDto);
            $this->profileRepository->save($profile, true);
            $this->cache->invalidateTags(['profiles']);//todo put into save?

            $this->sendEvent($profile);

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

    public function findOneBy(array $criteria, ?array $orderBy = null): ?Profile
    {
        return $this->profileRepository->findOneBy($criteria, $orderBy);
    }

    private function prepareEntity(ProfileDto $profileDto): Profile
    {
        $country = $this->countryService->findByCode($profileDto->countryCode);
        $city = $this->cityService->findById($profileDto->cityId);
        $profile = ProfileFactory::create(
            $profileDto,
            $country,
            $city
        );

        $hashedPassword = $this->passwordHasher->hashPassword($profile, $profileDto->password);
        $profile->setPassword($hashedPassword);

        return $profile;
    }

    private function sendEvent(Profile $profile): void
    {
        $event = new ProfileEvent($profile->getId(), $profile->getEmail());
        $this->eventDispatcher->dispatch($event, ProfileEvent::NAME);
    }
}
