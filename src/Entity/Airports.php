<?php

namespace App\Entity;

use App\Repository\AirportsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AirportsRepository::class)
 */
class Airports
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="airportName")
     */
    private $airportName;

    /**
     * @ORM\Column(type="integer", name="cityId")
     */
    private $cityId;

    /**
     * @ORM\Column(type="integer", name="countryId")
     */
    private $countryId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $added;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirportName(): ?string
    {
        return $this->airportName;
    }

    public function setAirportName(string $airportName): self
    {
        $this->airportName = $airportName;

        return $this;
    }

    public function getCityId(): ?int
    {
        return $this->cityId;
    }

    public function setCityId(int $cityId): self
    {
        $this->cityId = $cityId;

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    public function setCountryId(int $countryId): self
    {
        $this->countryId = $countryId;

        return $this;
    }

    public function getAdded(): ?\DateTimeInterface
    {
        return $this->added;
    }

    public function setAdded(?\DateTimeInterface $added): self
    {
        $this->added = $added;

        return $this;
    }
}
