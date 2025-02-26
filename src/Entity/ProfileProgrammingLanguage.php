<?php

namespace App\Entity;

use App\Repository\ProfileProgrammingLanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileProgrammingLanguageRepository::class)]
class ProfileProgrammingLanguage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Profile::class)]
    #[ORM\JoinColumn(name: "profile_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Profile $profile = null;

    #[ORM\ManyToOne(targetEntity: ProgrammingLanguage::class)]
    #[ORM\JoinColumn(name: "programming_language_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?ProgrammingLanguage $programmingLanguage = null;

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

    public function getProgrammingLanguage(): ?ProgrammingLanguage
    {
        return $this->programmingLanguage;
    }

    public function setProgrammingLanguage(?ProgrammingLanguage $programmingLanguage): self
    {
        $this->programmingLanguage = $programmingLanguage;

        return $this;
    }
}
