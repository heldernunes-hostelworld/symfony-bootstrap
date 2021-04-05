<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestPath;

use App\Domain\Context\AirportRoute\FindBestPath\Collection\AirportCollection;

class ResponseModel
{
    private AirportCollection $airportCollection;

    public function __construct(AirportCollection $airportCollection)
    {
        $this->airportCollection = $airportCollection;
    }

    public function getAirportCollection(): AirportCollection
    {
        return $this->airportCollection;
    }
}