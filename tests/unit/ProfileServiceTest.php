<?php

namespace App\Tests\Unit;

use App\Entity\Profile;
use App\Repository\ProfileRepository;
use App\Service\ProfileService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Psr\Log\LoggerInterface;
use App\Service\CountryService;
use App\Service\CityService;

class ProfileServiceTest extends TestCase
{
    public function testGetListReturnsArrayOfProfileObjects()
    {
        // Создаем тестовый объект Profile
        $profile = new Profile();
        // При необходимости установите значения полей через сеттеры или напрямую

        // Мокаем репозиторий, чтобы он возвращал массив объектов Profile
        $profileRepositoryMock = $this->createMock(ProfileRepository::class);
        $profileRepositoryMock->expects($this->once())
            ->method('findAllActive')
            ->willReturn([$profile]);
//        var_dump(get_class($profileRepositoryMock));die;

        // Мокаем EntityManagerInterface (не используется в данном тесте, поэтому можно оставить пустым)
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        // Мокаем UserPasswordHasherInterface
        $passwordHasherMock = $this->createMock(UserPasswordHasherInterface::class);

        // Мокаем CountryService
        $countryServiceMock = $this->createMock(CountryService::class);

        // Мокаем CityService
        $cityServiceMock = $this->createMock(CityService::class);

        // Мокаем кэш (TagAwareCacheInterface)
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
                // Симулируем установку ttl и тегов, если это необходимо
                $itemMock->expects($this->any())->method('expiresAfter')->with(3600);
                $itemMock->expects($this->any())->method('tag')->with(['profiles']);
                return $callback($itemMock);
            });

        // Мокаем LoggerInterface
        $loggerMock = $this->createMock(LoggerInterface::class);

        // Создаем экземпляр ProfileService с замоканными зависимостями.
        $profileService = new ProfileService(
            $profileRepositoryMock,
            $entityManagerMock,
            $passwordHasherMock,
            $countryServiceMock,
            $cityServiceMock,
            $cacheMock,
            $loggerMock
        );

        $result = $profileService->getList();

        $this->assertIsArray($result, 'Метод getList должен возвращать массив.');
        $this->assertNotEmpty($result, 'Метод getList не должен возвращать пустой массив.');

        foreach ($result as $item) {
            $this->assertInstanceOf(
                Profile::class,
                $item,
                'Каждый элемент результата должен быть экземпляром App\Entity\Profile.'
            );
        }
    }
}
