<?php

namespace App\Entity;

use App\Repository\BoendeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoendeRepository::class)]
class Boende
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Vecka = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $twthousandsixteen = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $twothousandseventeen = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $twothousandeighteen = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $twothousandnineteen = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $twothousandtwenty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVecka(): ?int
    {
        return $this->Vecka;
    }

    public function setVecka(int $Vecka): self
    {
        $this->Vecka = $Vecka;

        return $this;
    }

    public function getTwthousandsixteen(): ?string
    {
        return $this->twthousandsixteen;
    }

    public function setTwthousandsixteen(string $twthousandsixteen): self
    {
        $this->twthousandsixteen = $twthousandsixteen;

        return $this;
    }

    public function getTwothousandseventeen(): ?string
    {
        return $this->twothousandseventeen;
    }

    public function setTwothousandseventeen(string $twothousandseventeen): self
    {
        $this->twothousandseventeen = $twothousandseventeen;

        return $this;
    }

    public function getTwothousandeighteen(): ?string
    {
        return $this->twothousandeighteen;
    }

    public function setTwothousandeighteen(string $twothousandeighteen): self
    {
        $this->twothousandeighteen = $twothousandeighteen;

        return $this;
    }

    public function getTwothousandnineteen(): ?string
    {
        return $this->twothousandnineteen;
    }

    public function setTwothousandnineteen(string $twothousandnineteen): self
    {
        $this->twothousandnineteen = $twothousandnineteen;

        return $this;
    }

    public function getTwothousandtwenty(): ?string
    {
        return $this->twothousandtwenty;
    }

    public function setTwothousandtwenty(string $twothousandtwenty): self
    {
        $this->twothousandtwenty = $twothousandtwenty;

        return $this;
    }
}
