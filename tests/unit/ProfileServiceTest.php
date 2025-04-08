<?php

namespace App\Tests\Unit;

use App\Entity\Profile;
use App\Repository\ProfileRepository;
use App\Service\CityService;
use App\Service\CountryService;
use App\Service\ProfileService;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ProfileServiceTest extends TestCase
{
    public function testGetListReturnsArrayOfProfileObjects()
    {
        $profile = new Profile();

        $profileRepositoryMock = $this->createMock(ProfileRepository::class);
        $profileRepositoryMock->expects($this->once())
            ->method('findAllActive')
            ->willReturn([$profile]);

        $passwordHasherMock = $this->createMock(UserPasswordHasherInterface::class);
        $countryServiceMock = $this->createMock(CountryService::class);
        $cityServiceMock = $this->createMock(CityService::class);
        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $cacheMock = $this->createMock(TagAwareCacheInterface::class);
        $cacheMock->expects($this->once())
            ->method('get')
            ->with(
                'profiles.list',
                $this->callback(function ($callback) {
                    return is_callable($callback);
                })
            )
            ->willReturnCallback(function ($key, $callback) {
                $itemMock = $this->createMock(ItemInterface::class);
                $itemMock->expects($this->any())->method('expiresAfter')->with(3600);
                $itemMock->expects($this->any())->method('tag')->with(['profiles']);

                return $callback($itemMock);
            });

        $loggerMock = $this->createMock(LoggerInterface::class);

        $profileService = new ProfileService(
            $profileRepositoryMock,
            $passwordHasherMock,
            $countryServiceMock,
            $cityServiceMock,
            $cacheMock,
            $loggerMock,
            $eventDispatcherMock
        );

        $result = $profileService->getList();

        $this->assertIsArray($result, 'Method getList must return array.');
        $this->assertNotEmpty($result, 'Method getList shouldn\'t return an empty array.');

        foreach ($result as $item) {
            $this->assertInstanceOf(
                Profile::class,
                $item,
                'Every element must be instance of App\Entity\Profile.'
            );
        }
    }
}
