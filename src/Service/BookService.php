<?php

namespace App\Service;

use App\Entity\Author;
use App\Factories\BookFactory;
use App\Messages\LoadBooksMessage;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class BookService
{
    private const DEFAULT_URL = 'https://www.googleapis.com/books/v1/volumes?q=author:%s&maxResults=%d';

    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly MessageBusInterface $bus,
        private readonly LoggerInterface $logger,
    )
    {

    }

    public function loadBooksFromApi(array $authors): array
    {
        $result = [];
        $this->logger->info('start executing loadBooksFromApi');

        foreach ($authors as $author) {
            $this->bus->dispatch(new LoadBooksMessage($author));
        }

        return $result;
    }

    public function loadAndSaveBooksByAuthor(Author $author): void
    {
        $data = $this->getBooksByAuthor($author);

        foreach ($data as $bookInfo) {
            $title = $bookInfo['volumeInfo']['title'] ?? '';
            $dbBook = $this->bookRepository->findOneBy(['name' => $title]);

            if (!$dbBook) {
                $year = (int) substr($bookInfo['volumeInfo']['publishedDate'] ?? 0, 0, 4);
                $book = BookFactory::create($title, $year, $author);
                $this->bookRepository->save($book, true);
            }
        }
    }

    public function getBooksByAuthor(Author $author, int $limit = 40): array
    {
        $fullName = urlencode("{$author->getName()} {$author->getSurname()}");
        $url = sprintf(self::DEFAULT_URL, $fullName, $limit);
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        return $data['items'] ?? [];
    }

    public function getList(int $authorId): array
    {
        $author = $this->authorRepository->findOneBy(['id' => $authorId]);

        if (!$author) {
            throw new \Exception('author not found');
        }

        return $this->bookRepository->findBy(['author' => $author]);
    }
}
