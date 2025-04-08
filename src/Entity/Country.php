<?php

namespace App\Entity;

use App\Infrastructure\Interfaces\ArrayableInterface;
use App\Infrastructure\Traits\ArrayableTrait;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country implements ArrayableInterface
{
    use ArrayableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['country:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['country:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    #[Groups(['country:read'])]
    private ?string $alpha2 = null;

    #[ORM\Column(length: 3)]
    #[Groups(['country:read'])]
    private ?string $alpha3 = null;

    #[ORM\OneToMany(targetEntity: City::class, mappedBy: 'country', cascade: ['remove'])]
    #[Ignore]
    private Collection $cities;

    public function __construct()
    {
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

    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function setCities(Collection $cities): self
    {
        $this->cities = $cities;

        return $this;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setCountry($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            //            if ($city->getCountry() === $this) {//todo
            //                $city->setCountry(null);
            //            }
        }

        return $this;
    }
}
