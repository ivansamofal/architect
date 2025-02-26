<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\CountryRepository;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    public function __construct(
        private BookRepository $bookRepository,
    )
    {

    }

    public function loadBooksFromApi(array $authors): array
    {
        $result = [];

        $defaultUrl = 'https://www.googleapis.com/books/v1/volumes?q=author:%s&maxResults=%d';
        foreach ($authors as $author) {
            $fullName = urlencode("{$author->getName()} {$author->getSurname()}");
            $url = sprintf($defaultUrl, $fullName, 40);
            $data = file_get_contents($url);
            $data = json_decode($data, true);
            if (!empty($data['items'])) {
                foreach ($data['items'] as $bookInfo) {
                    $title = $bookInfo['volumeInfo']['title'];
                    $dbBook = $this->bookRepository->findOneBy(['name' => $title]);
                    if (!$dbBook) {
                        $book = new Book();
                        $book->setActive(true);
                        $year = substr($bookInfo['volumeInfo']['publishedDate'] ?? 0, 0, 4);
                        $book->setName($bookInfo['volumeInfo']['title']);
                        $book->setAuthor($author);
                        $book->setYear($year);
                        $this->bookRepository->save($book, true);
                        $result[] = $title;
                    }
                }
            }
        }

        return $result;
    }
}
