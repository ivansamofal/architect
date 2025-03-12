<?php

namespace App\Controller\Api;

use App\Service\Mongo\BookReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends AbstractController
{
    public function __construct(private readonly BookReviewService $bookReviewService)
    {
    }

    /**
     *
     * #[Route('/reviews')]
     */
    public function index(): JsonResponse
    {
        $reviews = $this->bookReviewService->getReviews();

        return $this->json($reviews);
    }

    /**
     *
     * #[Route('/reviews')]
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $review = $this->bookReviewService->addReview($data);

            return $this->json([
                'message' => 'success',
                'data' => $review,
            ]);
        } catch (\Throwable $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }
    }
}
