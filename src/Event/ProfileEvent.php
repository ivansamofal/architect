<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ProfileEvent extends Event
{
    public const NAME = 'user.created';

    private int $profileId;
    private string $email;

    public function __construct(int $profileId, string $email)
    {
        $this->profileId = $profileId;
        $this->email = $email;
    }

    public function getProfileId(): int
    {
        return $this->profileId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
