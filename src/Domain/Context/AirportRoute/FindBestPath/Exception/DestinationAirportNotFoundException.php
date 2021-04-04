<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestPath\Exception;

use Exception;

class DestinationAirportNotFoundException extends Exception
{
    public $message = 'Destination airport not found for the given airport ID';
}