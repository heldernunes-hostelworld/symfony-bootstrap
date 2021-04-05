<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestPath\Collection;

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

    public function addPossibleRoute(Airport $origin, Airport $destination): self
    {
        if (empty($this->get($origin->getId()))) {
            $this->possibleRoutes[$origin->getId()] = AirportCollection::createEmpty()->addAirport($destination);
        } else {
            $this->possibleRoutes[$origin->getId()]->addAirport($destination);
        }

        return $this;
    }

    public function getAll(): array
    {
        return $this->possibleRoutes;
    }

    public function get(int $airportId): ?AirportCollection
    {
        return $this->possibleRoutes[$airportId] ?? null;
    }
}