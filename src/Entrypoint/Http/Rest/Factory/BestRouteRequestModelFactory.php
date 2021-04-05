<?php declare(strict_types=1);
namespace App\Entrypoint\Http\Rest\Factory;

use App\Domain\Context\AirportRoute\FindBestPath\RequestModel;

class BestRouteRequestModelFactory
{
    public static function create(int $originAirportId, int $destination): RequestModel
    {
        return new RequestModel($originAirportId, $destination);
    }
}