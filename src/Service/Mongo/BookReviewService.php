<?php

namespace App\Service\Mongo;

use App\Document\BookReview;
use App\Exceptions\ReviewNotCreatedException;
use App\Service\NotifyService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;

class BookReviewService
{
    public function __construct(
        private readonly DocumentManager $dm,
        private readonly NotifyService $notifyService,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function addReview(array $data): BookReview
    {
        if (empty($data['bookId'])) {
            throw new \Exception('Book ID is required');
        }

        if (empty($data['profileId'])) {
            throw new \Exception('profile ID is required');
        }

        if (empty($data['rating'])) {
            throw new \Exception('rating is required');
        }

        try {
            $review = $this->dm->getRepository(BookReview::class)->findOneBy(['bookId' => $data['bookId']]);

            if (!$review) {
                $review = new BookReview();
                $review->setBookId($data['bookId']);
            }

            $review->addReview($data['profileId'], $data['rating'], $data['comment'] ?? '');
            $this->dm->persist($review);
            $this->dm->flush();

            $this->notifyService->sendNotice('review has created 😎!');

            return $review;
        } catch (\Throwable $e) {
            $this->logger->error("Error during create review. Cause: {$e->getMessage()}. {$e->getFile()}:{$e->getLine()}");

            throw new ReviewNotCreatedException();
        }
    }

    public function getReviews(): array
    {
        return $this->dm->getRepository(BookReview::class)->findAll();
    }

    public function getAverageRating(int $bookId): float
    {
        $review = $this->dm->getRepository(BookReview::class)->findOneBy(['bookId' => $bookId]);

        if (!$review || empty($review->getReviews())) {
            return 0;
        }

        $total = array_sum(array_column($review->getReviews(), 'rating'));

        return round($total / count($review->getReviews()), 1);
    }
}
