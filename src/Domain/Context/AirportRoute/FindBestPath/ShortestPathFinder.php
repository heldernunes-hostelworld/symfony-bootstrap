<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestPath;

use App\Domain\Context\AirportRoute\FindBestPath\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestPath\Collection\PossibleRoutesCollection;
use App\Domain\Shared\Entity\Airport;

interface ShortestPathFinder
{
    public function findShortestPath(
        PossibleRoutesCollection $possibleRoutesCollection,
        Airport $origin,
        Airport $destination
    ): AirportCollection;
}