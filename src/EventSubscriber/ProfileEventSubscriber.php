<?php

namespace App\EventSubscriber;

use App\Event\ProfileEvent;
use App\Service\NotifyService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProfileEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly NotifyService $notificationService)
    {

    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProfileEvent::NAME => 'onProfileCreated',
        ];
    }

    public function onProfileCreated(ProfileEvent $event): void
    {
        $profileId = $event->getProfileId();
        $email = $event->getEmail();
        $message = "Profile with ID $profileId and email $email has created 😎";

        $this->notificationService->sendNotice($message);
    }
}
