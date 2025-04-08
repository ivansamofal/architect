<?php

namespace App\MessageHandlers;

use App\Messages\LoadBooksMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class LoadBooksHandler
{
    public function __construct(
        private readonly BookService $bookService,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(LoadBooksMessage $message): void
    {
        try {
            $author = $message->getAuthor();
            $this->logger->info('Loading books for author: '.$message->getAuthor()->getId());
            $this->bookService->loadAndSaveBooksByAuthor($author);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Ошибка обработки: '.$e->getMessage());
        }
    }
}
