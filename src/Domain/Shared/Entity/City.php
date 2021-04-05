<?php declare(strict_types=1);
namespace App\Domain\Shared\Entity;

use DateTime;

class City
{
    private ?int $id;

    private string $name;

    private Country $country;

    private DateTime $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): City
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): City
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): City
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): City
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}