<?php

namespace App\Repository;

use App\Entity\SaisirAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SaisirAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaisirAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaisirAdresse[]    findAll()
 * @method SaisirAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaisirAdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaisirAdresse::class);
    }

    // /**
    //  * @return SaisirAdresse[] Returns an array of SaisirAdresse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SaisirAdresse
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
