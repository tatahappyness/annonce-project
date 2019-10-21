<?php

namespace App\Repository;

use App\Entity\GuidePrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GuidePrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuidePrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuidePrice[]    findAll()
 * @method GuidePrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuidePriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GuidePrice::class);
    }

    // /**
    //  * @return GuidePrice[] Returns an array of GuidePrice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GuidePrice
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
