<?php declare(strict_types=1);
namespace App\Infrastructure\AirportRoute;

use App\Domain\Context\AirportRoute\FindBestRoute\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestRoute\Collection\PossibleRoutesCollection;
use App\Domain\Context\AirportRoute\FindBestRoute\ShortestPathFinder;
use App\Domain\Shared\Entity\Airport;
use App\Infrastructure\AirportRoute\Exception\OriginAirportHasNoAdjacentAirportsException;

class BestRouteFinder implements ShortestPathFinder
{
    /**
     * @param PossibleRoutesCollection $possibleRoutesCollection
     * @param Airport $origin
     * @param Airport $destination
     *
     * @return AirportCollection
     */
    public function findShortestPath(
        PossibleRoutesCollection $possibleRoutesCollection,
        Airport $origin,
        Airport $destination
    ): AirportCollection
    {
        $airportGraph = new AirportGraph($possibleRoutesCollection);

        return $airportGraph->breadthFirstSearch($origin, $destination);
    }
}