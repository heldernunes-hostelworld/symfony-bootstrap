<?php declare(strict_types=1);
namespace App\Domain\Shared\Entity;

use DateTime;

class Route
{
    private ?int $id;

    private Airport $origin;

    private Airport $destiny;

    private DateTime $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Route
    {
        $this->id = $id;

        return $this;
    }

    public function getOrigin(): Airport
    {
        return $this->origin;
    }

    public function setOrigin(Airport $origin): Route
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDestiny(): Airport
    {
        return $this->destiny;
    }

    public function setDestiny(Airport $destiny): Route
    {
        $this->destiny = $destiny;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Route
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}