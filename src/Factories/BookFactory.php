<?php

namespace App\Factories;

use App\Entity\Author;
use App\Entity\Book;

class BookFactory
{
    public static function create(string $title, int $year, Author $author): Book
    {
        $entity = new Book();
        $entity->setActive(true);
        $entity->setName($title);
        $entity->setAuthor($author);
        $entity->setYear($year);

        return $entity;
    }
}
