<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute;

use App\Domain\Context\AirportRoute\FindBestRoute\Collection\AirportCollection;

class ResponseModel
{
    /** @var AirportCollection */
    private $airportCollection;

    public function __construct(AirportCollection $airportCollection)
    {
        $this->airportCollection = $airportCollection;
    }

    public function getAirportCollection(): AirportCollection
    {
        return $this->airportCollection;
    }
}