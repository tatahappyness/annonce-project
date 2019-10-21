<?php

namespace App\Repository;

use App\Entity\ChantierOfMonth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChantierOfMonth|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChantierOfMonth|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChantierOfMonth[]    findAll()
 * @method ChantierOfMonth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChantierOfMonthRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChantierOfMonth::class);
    }

    // /**
    //  * @return ChantierOfMonth[] Returns an array of ChantierOfMonth objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChantierOfMonth
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
