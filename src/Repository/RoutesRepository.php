<?php

namespace App\Repository;

use App\Entity\Routes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Routes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Routes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Routes[]    findAll()
 * @method Routes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoutesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Routes::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Routes $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Routes $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Routes[] Returns an array of Routes objects
    //  */
    public function findDirectRoute($origin, $destination)
    {
        return $this->createQueryBuilder('r')
            ->Where("r.origin = '" . $origin."'")
            ->andWhere("r.destiny = '".$destination."'")
            //->join('r.cursoAcademico', 'c')
            ->getQuery()
            ->getOneOrNullResult()
        ;

    }

    /*
    public function findOneBySomeField($value): ?Routes
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
