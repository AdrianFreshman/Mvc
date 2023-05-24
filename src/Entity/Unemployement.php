<?php

namespace App\Entity;

use App\Repository\UnemployementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnemployementRepository::class)]
class Unemployement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $ageRange = null;

    #[ORM\Column]
    private ?float $age2018 = null;

    #[ORM\Column]
    private ?float $age2019 = null;

    #[ORM\Column]
    private ?float $age2020 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgeRange(): ?string
    {
        return $this->ageRange;
    }

    public function setAgeRange(string $ageRange): self
    {
        $this->ageRange = $ageRange;

        return $this;
    }

    public function getAge2018(): ?float
    {
        return $this->age2018;
    }

    public function setAge2018(float $age2018): self
    {
        $this->age2018 = $age2018;

        return $this;
    }

    public function getAge2019(): ?float
    {
        return $this->age2019;
    }

    public function setAge2019(float $age2019): self
    {
        $this->age2019 = $age2019;

        return $this;
    }

    public function getAge2020(): ?float
    {
        return $this->age2020;
    }

    public function setAge2020(float $age2020): self
    {
        $this->age2020 = $age2020;

        return $this;
    }
}
