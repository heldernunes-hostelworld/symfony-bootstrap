<?php declare(strict_types=1);
namespace App\Infrastructure\AirportRoute;

use App\Domain\Context\AirportRoute\FindBestRoute\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestRoute\Collection\PossibleRoutesCollection;
use App\Domain\Shared\Entity\Airport;
use App\Infrastructure\AirportRoute\Exception\OriginAirportHasNoAdjacentAirportsException;
use SplQueue;

class AirportGraph
{
    protected PossibleRoutesCollection $adjacencyList;

    protected array $visited = [];

    public function __construct(PossibleRoutesCollection $adjacencyList)
    {
        $this->adjacencyList = $adjacencyList;
    }

    public function breadthFirstSearch(Airport $origin, Airport $destination): AirportCollection
    {
        $originAdjacentAirports = $this->adjacencyList->get($origin->getId());
        $destinationAdjacentAirports = $this->adjacencyList->get($destination->getId());

        if (empty($originAdjacentAirports) || $originAdjacentAirports->isEmpty()) {
            return AirportCollection::createEmpty();
        }

        if (empty($destinationAdjacentAirports)) {
            $this->adjacencyList->addPossibleRoutes($destination, AirportCollection::createEmpty());
        }

        $this->markAllAirportsAsUnvisited();

        $airportsToBeVisitedQueue = new SplQueue();
        $airportsToBeVisitedQueue->enqueue($origin);

        $this->visited[$origin->getId()] = true;

        $path = [];
        $path[$origin->getId()] = [];
        $path[$origin->getId()][] = $origin;

        while (!$airportsToBeVisitedQueue->isEmpty() && $airportsToBeVisitedQueue->bottom() != $destination) {
            /** @var Airport $airportToVisit */
            $airportToVisit = $airportsToBeVisitedQueue->dequeue();

            $adjacentAirports = $this->adjacencyList->get($airportToVisit->getId())->getAll();

            if (!empty($adjacentAirports)) {
                foreach ($adjacentAirports as $adjacentAirport) {
                    if ($this->adjacentAirportIsProcessable($adjacentAirport)) {
                        $airportsToBeVisitedQueue->enqueue($adjacentAirport);

                        $this->markAirportAsVisited($adjacentAirport);

                        $path[$adjacentAirport->getId()] = $path[$airportToVisit->getId()];
                        $path[$adjacentAirport->getId()][] = $adjacentAirport;
                    }
                }
            }
        }

        return AirportCollection::createFromArray($path[$destination->getId()] ?? []);
    }

    private function markAllAirportsAsUnvisited(): void
    {
        foreach ($this->adjacencyList->getAll() as $airportId => $adjacentAirports) {
            $this->visited[$airportId] = false;
        }
    }

    private function markAirportAsVisited(Airport $airport): void
    {
        $this->visited[$airport->getId()] = true;
    }

    private function adjacentAirportIsProcessable(mixed $adjacentAirport): bool
    {
        return $this->adjacentAirportHasAdjacentAirports($adjacentAirport)
            && !$this->adjacentAirportWasVisited($adjacentAirport);
    }

    private function adjacentAirportHasAdjacentAirports(Airport $adjacentAirport): bool
    {
        return !empty($this->adjacencyList->get($adjacentAirport->getId()));
    }

    private function adjacentAirportWasVisited(mixed $adjacentAirport): bool
    {
        return $this->visited[$adjacentAirport->getId()];
    }
}