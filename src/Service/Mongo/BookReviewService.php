<?php

namespace App\Service\Mongo;

use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\BookReview;

class BookReviewService
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
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

        $review = $this->dm->getRepository(BookReview::class)->findOneBy(['bookId' => $data['bookId']]);

        if (!$review) {
            $review = new BookReview();
            $review->setBookId($data['bookId']);
        }

        $review->addReview($data['profileId'], $data['rating'], $data['comment'] ?? '');
        $this->dm->persist($review);
        $this->dm->flush();

        return $review;
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