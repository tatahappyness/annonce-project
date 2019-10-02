<?php

namespace App\Repository;

use App\Entity\Abonnenent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Abonnenent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonnenent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonnenent[]    findAll()
 * @method Abonnenent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnenentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Abonnenent::class);
    }

    // /**
    //  * @return Abonnenent[] Returns an array of Abonnenent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Abonnenent
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
