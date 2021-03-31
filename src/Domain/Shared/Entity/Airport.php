<?php declare(strict_types=1);
namespace App\Domain\Shared\Entity;

use DateTimeImmutable;

class Airport
{
    /** @var ?int */
    private $id;

    /** @var string */
    private $name;

    /** @var City */
    private $city;

    /** @var Country */
    private $country;

    /** @var DateTimeImmutable */
    private $createdAt;

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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Airport
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}