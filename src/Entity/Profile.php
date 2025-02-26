<?php

namespace App\Entity;

use App\Infrastructure\Interfaces\ArrayableInterface;
use App\Infrastructure\Traits\ArrayableTrait;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile implements ArrayableInterface, PasswordAuthenticatedUserInterface
{
    use ArrayableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct()
    {
        $this->profileBooks = new ArrayCollection();
        $this->profileInterests = new ArrayCollection();
        $this->profileProgrammingLanguages = new ArrayCollection();
    }

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    #[ORM\JoinColumn(name: 'country_id', referencedColumnName: 'id', nullable: true, onDelete: "SET NULL")]
    private ?Country $country = null;

    #[ORM\Column(nullable: true)]
    private ?int $avatar_id = null; // Если это ID, а не связь с Avatar

    #[ORM\Column(nullable: true)]
    private ?int $gender = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

//    #[ORM\OneToMany(targetEntity: ProfileBook::class, mappedBy: 'profile', cascade: ['remove'])]
//    private Collection $profileBooks;
//
//    #[ORM\OneToMany(targetEntity: ProfileInterest::class, mappedBy: 'profile', cascade: ['remove'])]
//    private Collection $profileInterests;

    #[ORM\OneToMany(targetEntity: ProfileProgrammingLanguage::class, mappedBy: 'profile', cascade: ['remove'])]
    private Collection $profileProgrammingLanguages;

    #[ORM\OneToMany(targetEntity: ProfileBook::class, mappedBy: 'profile')]
    #[Groups(['profile:read'])]
    private $profileBooks;


    #[ORM\OneToMany(targetEntity: ProfileInterest::class, mappedBy: 'profile', cascade: ['remove'], fetch: 'EAGER')]
    private Collection $profileInterests;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getAvatarId(): ?int
    {
        return $this->avatar_id;
    }

    public function setAvatarId(?int $avatar_id): self
    {
        $this->avatar_id = $avatar_id;
        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getProfileBooks(): Collection
    {
        return $this->profileBooks;
    }

    public function getProfileInterests(): Collection
    {
        return $this->profileInterests;
    }

    public function getProfileProgrammingLanguages(): Collection
    {
        return $this->profileProgrammingLanguages;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
