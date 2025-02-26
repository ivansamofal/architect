<?php

namespace App\Entity;

use App\Repository\ProfileInterestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileInterestRepository::class)]
class ProfileInterest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Profile::class)]
    #[ORM\JoinColumn(name: "profile_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Profile $profile = null;

    #[ORM\ManyToOne(targetEntity: Interest::class)]
    #[ORM\JoinColumn(name: "interest_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Interest $interest = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfileId(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getInterest(): ?Interest
    {
        return $this->interest;
    }

    public function setInterest(?Interest $interest): self
    {
        $this->interest = $interest;

        return $this;
    }
}
