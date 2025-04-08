<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class BookReview
{
    #[MongoDB\Id]
    private string $id;

    #[MongoDB\Field(type: 'int')]
    private int $bookId;

    #[MongoDB\Field(type: 'collection')]
    private array $reviews = [];

    public function addReview(int $profileId, int $rating, string $comment): void
    {
        $this->reviews[] = [
            'profileId' => $profileId,
            'rating' => $rating,
            'comment' => $comment,
            'date' => new \DateTime(),
        ];
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): self
    {
        $this->bookId = $bookId;

        return $this;
    }
}
