<?php

namespace App\Service;

use App\Repository\AuthorRepository;

class AuthorService
{
    public function __construct(private AuthorRepository $authorRepository)
    {

    }

    public function getAll(): array
    {
        return $this->authorRepository->findAll();
    }
}
