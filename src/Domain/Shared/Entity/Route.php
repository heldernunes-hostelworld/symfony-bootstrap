<?php declare(strict_types=1);
namespace App\Domain\Shared\Entity;

use DateTimeImmutable;

class Route
{
    /** @var ?int */
    private $id;

    /** @var string */
    private $origin;

    /** @var string */
    private $destiny;

    /** @var DateTimeImmutable */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Route
    {
        $this->id = $id;

        return $this;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): Route
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDestiny(): string
    {
        return $this->destiny;
    }

    public function setDestiny(string $destiny): Route
    {
        $this->destiny = $destiny;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Route
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}