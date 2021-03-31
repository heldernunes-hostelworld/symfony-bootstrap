<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute\Validator;

use App\Domain\Context\AirportRoute\FindBestRoute\Exception\DestinationAirportNotFoundException;
use App\Domain\Context\AirportRoute\FindBestRoute\Exception\OriginAirportNotFoundException;
use App\Domain\Shared\Entity\Airport;

class Semantic
{
    /**
     * @param ?Airport $originAirport
     * @param ?Airport $destinationAirport
     *
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     *
     * @return bool
     */
    public function validate(?Airport $originAirport, ?Airport $destinationAirport): bool
    {
        if (empty($originAirport)) {
            throw new OriginAirportNotFoundException();
        }

        if (empty($destinationAirport)) {
            throw new DestinationAirportNotFoundException();
        }

        return true;
    }
}