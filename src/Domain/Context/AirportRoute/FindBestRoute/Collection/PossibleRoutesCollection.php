<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute\Collection;

use App\Domain\Shared\Entity\Airport;

class PossibleRoutesCollection
{
    /** @var AirportCollection[] */
    private $possibleRoutes = [];

    public static function create(): self
    {
        return new self();
    }

    public function addPossibleRoutes(Airport $airport, AirportCollection $possibleRoutes): self
    {
        $this->possibleRoutes[$airport->getId()] = $possibleRoutes;

        return $this;
    }

    public function getAll(): array
    {
        return $this->possibleRoutes;
    }

    public function get(int $airportId): ?AirportCollection
    {
        return $this->airports[$airportId] ?? null;
    }
}