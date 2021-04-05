<?php declare(strict_types=1);
namespace App\Domain\Context\AirportRoute\FindBestPath;

use App\Domain\Shared\Entity\Airport;

interface AirportRepository
{
    public function getById(int $id): ?Airport;
}