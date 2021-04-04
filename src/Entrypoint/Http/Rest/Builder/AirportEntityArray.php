<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Builder;

use App\Domain\Shared\Entity\Airport;

class AirportEntityArray
{
    public static function build(Airport $airport): array
    {
        return [
            'airportId' => $airport->getId(),
            'cityId' => $airport->getCity()->getId(),
            'cityName' => $airport->getCity()->getName(),
            'countryName' => $airport->getCountry()->getName()
        ];
    }
}