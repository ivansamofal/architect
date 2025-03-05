<?php

namespace App\Entity;

use App\Infrastructure\Interfaces\ArrayableInterface;
use App\Infrastructure\Traits\ArrayableTrait;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country implements ArrayableInterface
{
    use ArrayableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $alpha2 = null;

    #[ORM\Column(length: 3)]
    private ?string $alpha3 = null;

    #[ORM\OneToMany(targetEntity: City::class, mappedBy: 'city', cascade: ['remove'])]
    private Collection $cities;

    public function __construct() {
        $this->cities = new ArrayCollection();
    }

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

    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function setAlpha2(string $alpha2): self
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    public function getAlpha3(): ?string
    {
        return $this->alpha3;
    }

    public function setAlpha3(string $alpha3): self
    {
        $this->alpha3 = $alpha3;

        return $this;
    }

    public function getCities(): ArrayCollection
    {
        return $this->cities;
    }
}
