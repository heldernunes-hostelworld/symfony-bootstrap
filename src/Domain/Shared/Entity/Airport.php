<?php declare(strict_types=1);
namespace App\Domain\Shared\Entity;

use DateTime;

class Airport
{
    private ?int $id;

    private string $name;

    private City $city;

    private Country $country;

    private DateTime $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Airport
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Airport
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): Airport
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): Airport
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Airport
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}