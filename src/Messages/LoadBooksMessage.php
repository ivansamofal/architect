<?php

namespace App\Messages;

use App\Entity\Author;

class LoadBooksMessage
{
    private Author $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }
}
