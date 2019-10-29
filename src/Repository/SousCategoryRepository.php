<?php

namespace App\Repository;

use App\Entity\SousCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SousCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousCategory[]    findAll()
 * @method SousCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SousCategory::class);
    }

    // /**
    //  * @return SousCategory[] Returns an array of SousCategory objects
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
    public function findOneBySomeField($value): ?SousCategory
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
