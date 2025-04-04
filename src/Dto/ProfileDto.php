<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

class ProfileDto
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $surname;

    #[Assert\NotBlank]
    public string $password;

    #[Assert\NotBlank]
    public int $status;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[CustomAssert\UniqueEmail]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(exactly: 2)]
    public string $countryCode;

    #[Assert\NotBlank]
    public int $cityId;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeImmutable::class)]
    public \DateTimeImmutable $birthDate;
}
