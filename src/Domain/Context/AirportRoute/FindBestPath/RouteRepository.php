<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestPath;

use App\Domain\Context\AirportRoute\FindBestPath\Collection\PossibleRoutesCollection;

interface RouteRepository
{
    public function fetchAirportsPossibleRoutes(): PossibleRoutesCollection;
}