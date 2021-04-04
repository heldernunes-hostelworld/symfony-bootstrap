<?php declare(strict_types=1);
namespace App\Domain\Shared\Entity;

use DateTime;

class Country
{
    private ?int $id;

    private string $name;

    private DateTime $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Country
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Country
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Country
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}