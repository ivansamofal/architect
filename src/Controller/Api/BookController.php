<?php

namespace App\Controller\Api;

use App\Service\AuthorService;
use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly BookService $bookService,
    ) {
    }

    /**
     * #[Route('/authors')].
     */
    public function authorsList(Request $request): JsonResponse
    {
        $authors = $this->authorService->getAll();

        return $this->json($authors);
    }

    /**
     * #[Route('/books/:id')].
     */
    public function getBooksByAuthor(int $authorId): JsonResponse
    {
        $books = $this->bookService->getList($authorId);

        return $this->json($books);
    }
}
