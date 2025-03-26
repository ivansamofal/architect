<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class NotifyService
{
    public function __construct(private readonly NotifierInterface $notifier, private readonly LoggerInterface $logger,) {}

    public function sendNotice(string $message): void
    {
        try {
            $notification = (new Notification($message, ['chat/telegram']))
                ->content('hello 😎');
            $this->notifier->send($notification);
        } catch (\Throwable $e) {
            $this->logger->error("Error during sending telegram message. cause: {$e->getMessage()}");
        }
    }
}
