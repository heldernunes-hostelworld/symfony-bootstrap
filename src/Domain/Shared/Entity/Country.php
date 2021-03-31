<?php declare(strict_types=1);
namespace App\Domain\Shared\Entity;

use DateTimeImmutable;

class Country
{
    /** @var ?int */
    private $id;

    /** @var string */
    private $name;

    /** @var DateTimeImmutable */
    private $createdAt;

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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Country
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}