<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute;

class RequestModel
{
    /** @var int */
    private $originAirportId;

    /** @var int */
    private $destinationAirportId;

    public function __construct(int $originAirportId, int $destinationAirportId)
    {
        $this->originAirportId = $originAirportId;
        $this->destinationAirportId = $destinationAirportId;
    }

    public function getOriginAirportId(): int
    {
        return $this->originAirportId;
    }

    public function getDestinationAirportId(): int
    {
        return $this->destinationAirportId;
    }
}