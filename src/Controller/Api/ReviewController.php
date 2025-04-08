<?php

namespace App\Controller\Api;

use App\Service\Mongo\BookReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;

class ReviewController extends AbstractController
{
    public function __construct(private readonly BookReviewService $bookReviewService)
    {
    }

    /**
     * #[Route('/reviews')].
     */
    public function index(
        #[Autowire(service: 'limiter.api_user_limit')]
        RateLimiterFactory $apiUserLimit,
    ): JsonResponse {
        $limiter = $apiUserLimit->create($_SERVER['REMOTE_ADDR']);
        $limit = $limiter->consume();

        if (!$limit->isAccepted()) {
            throw new TooManyRequestsHttpException('Rate limit exceeded');
        }

        $reviews = $this->bookReviewService->getReviews();

        return $this->json($reviews);
    }

    /**
     * #[Route('/reviews')].
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
