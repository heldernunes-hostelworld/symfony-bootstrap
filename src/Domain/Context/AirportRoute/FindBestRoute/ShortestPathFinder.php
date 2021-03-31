<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute;

use App\Domain\Context\AirportRoute\FindBestRoute\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestRoute\Collection\PossibleRoutesCollection;
use App\Domain\Shared\Entity\Airport;

interface ShortestPathFinder
{
    public function findShortestPath(
        PossibleRoutesCollection $possibleRoutesCollection,
        Airport $origin,
        Airport $destination
    ): AirportCollection;
}