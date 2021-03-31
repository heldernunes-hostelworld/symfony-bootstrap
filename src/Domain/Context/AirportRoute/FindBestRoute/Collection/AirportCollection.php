<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestRoute\Collection;

use App\Domain\Shared\Entity\Airport;

class AirportCollection
{
    /** @var Airport[] */
    private $airports;

    private function __construct(array $airports)
    {
        $this->airports = $airports;
    }

    public static function create(): self
    {
        return new self([]);
    }

    public static function createFromArray(array $airports): self
    {
        return new self($airports);
    }


    public function addAirport(Airport $airport): self
    {
        $this->airports[] = $airport;

        return $this;
    }

    public function getAll(): array
    {
        return $this->airports;
    }
}