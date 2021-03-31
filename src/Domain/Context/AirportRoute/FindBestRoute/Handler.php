<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute;

use App\Domain\Context\AirportRoute\FindBestRoute\Exception\DestinationAirportNotFoundException;
use App\Domain\Context\AirportRoute\FindBestRoute\Exception\OriginAirportNotFoundException;

interface Handler
{
    /**
     * @param RequestModel $useCaseRequest
     *
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     *
     * @return ResponseModel
     */
    public function findBestRoute(RequestModel $useCaseRequest): ResponseModel;
}