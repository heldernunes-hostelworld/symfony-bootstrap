<?php declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Context\AirportRoute\FindBestPath\AirportRepository as FindBestPathAirportRepository;
use App\Domain\Shared\Entity\Airport as AirportEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AirportRepository extends ServiceEntityRepository implements FindBestPathAirportRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AirportEntity::class);
    }

    public function getById(int $id): ?AirportEntity
    {
        /** @var ?AirportEntity $airport */
        $airport = $this->find($id);

        return $airport;
    }
}