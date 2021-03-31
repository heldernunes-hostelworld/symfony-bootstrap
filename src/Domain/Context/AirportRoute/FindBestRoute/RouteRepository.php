<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute;

use App\Domain\Context\AirportRoute\FindBestRoute\Collection\PossibleRoutesCollection;

interface RouteRepository
{
    public function fetchAirportsPossibleRoutes(): PossibleRoutesCollection;
}