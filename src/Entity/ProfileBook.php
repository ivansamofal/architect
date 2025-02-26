<?php

namespace App\Entity;

use App\Repository\ProfileBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfileBookRepository::class)]
class ProfileBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'profileBooks')]
    #[ORM\JoinColumn(name: 'profile_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Profile $profile = null;

    #[Groups(['profile'])]
    #[ORM\OneToOne(targetEntity: Book::class)]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBookId(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}
