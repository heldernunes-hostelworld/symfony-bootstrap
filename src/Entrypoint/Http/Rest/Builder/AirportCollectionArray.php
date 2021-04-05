<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Builder;

use App\Domain\Context\AirportRoute\FindBestPath\Collection\AirportCollection;
use App\Entrypoint\Http\Rest\Builder\AirportEntityArray as AirportEntityArrayBuilder;
use App\Domain\Shared\Entity\Airport;

class AirportCollectionArray
{
    public static function build(AirportCollection $airportCollection): array
    {
        return array_map(
            function(Airport $airport) {
                return AirportEntityArrayBuilder::build($airport);
            },
            $airportCollection->getAll()
        );
    }
}