<?php

namespace App\Service;

use App\Entity\Airport;
use App\Exception\RuntimeException;
use Doctrine\ORM\EntityManagerInterface;
use Fhaculty\Graph\Exception\OutOfBoundsException;
use Fhaculty\Graph\Graph;
use Graphp\Algorithms\ShortestPath\Dijkstra;

class BestRouteFinder
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Returns the best route (a route with the minimum layovers) from one airport to another.
     *
     * @param int $from An airport ID to find the route from.
     * @param int $to An airport ID to find the route to.
     * @return Airport[] An ordered sequence of airport entities.
     */
    public function find(int $from, int $to): array
    {
        $airports = $this->entityManager->getRepository(Airport::class)->findAll();
        $airportIds = array_map(function (Airport $airport) {
            return $airport->getId();
        }, $airports);
        $invalidAirportIds = array_diff([$from, $to], $airportIds);
        if ($invalidAirportIds) {
            throw new RuntimeException(sprintf('The airport #%d has not been found', reset($invalidAirportIds)));
        }

        $vertices = (new Graph())->createVertices($airportIds)->getMap();
        foreach ($airports as $originAirport) {
            $origin = $vertices[$originAirport->getId()];
            foreach ($originAirport->getRoutes() as $destinyAirport) {
                $origin->createEdgeTo($vertices[$destinyAirport->getId()]);
            }
        }

        try {
            // For the bigger dataset we could find the shortest path
            // using features provided by the MariaDB OQGRAPH storage engine
            $path = (new Dijkstra($vertices[$from]))->getWalkTo($vertices[$to]);
        } catch (OutOfBoundsException $exception) {
            throw new RuntimeException('No route found between the given airports');
        }

        $bestRoute = [];
        foreach ($path->getVertices()->getIds() as $airportId) {
            $index = array_search($airportId, $airportIds);
            $bestRoute[] = $airports[$index];
        }

        return $bestRoute;
    }
}
