<?php

namespace App\Repository;

use App\Entity\ThemeColor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ThemeColor|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThemeColor|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThemeColor[]    findAll()
 * @method ThemeColor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeColorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ThemeColor::class);
    }

    // /**
    //  * @return ThemeColor[] Returns an array of ThemeColor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ThemeColor
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
