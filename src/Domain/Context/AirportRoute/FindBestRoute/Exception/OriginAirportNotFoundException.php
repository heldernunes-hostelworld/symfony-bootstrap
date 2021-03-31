<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute\Exception;

use Exception;

class OriginAirportNotFoundException extends Exception
{
    public $message = 'Origin airport not found for the given airport ID';
}