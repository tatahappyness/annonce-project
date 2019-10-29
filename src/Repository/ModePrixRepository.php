<?php

namespace App\Repository;

use App\Entity\ModePrix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModePrix|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModePrix|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModePrix[]    findAll()
 * @method ModePrix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModePrixRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModePrix::class);
    }

    // /**
    //  * @return Videos[] Returns an array of Videos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Videos
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
