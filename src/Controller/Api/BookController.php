<?php

namespace App\Controller\Api;

use App\Service\AuthorService;
use App\Service\BookService;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController
{
    public function __construct(
        private AuthorService $authorService,
        private BookService $bookService,
    )
    {
    }

    /**
     *
     * #[Route('/books/load')]
     */
    public function load(Request $request): JsonResponse
    {
        $authors = $this->authorService->getAll();
//        var_dump($authors);die;
        $result = $this->bookService->loadBooksFromApi($authors);

        return new JsonResponse(
            $result,
            Response::HTTP_OK
        );
    }

    /**
     *
     * #[Route('/books')]
     */
    public function test(): JsonResponse
    {
        echo 22244;die;
    }

    /**
     *
     * #[Route('/profiles')]
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $profile = $this->profileService->createProfile($data);

        return new JsonResponse(['id' => $profile->getId()], 201);
    }
}
