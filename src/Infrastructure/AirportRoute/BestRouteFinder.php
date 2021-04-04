<?php declare(strict_types=1);
namespace App\Infrastructure\AirportRoute;

use App\Domain\Context\AirportRoute\FindBestPath\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestPath\Collection\PossibleRoutesCollection;
use App\Domain\Context\AirportRoute\FindBestPath\ShortestPathFinder;
use App\Domain\Shared\Entity\Airport;

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