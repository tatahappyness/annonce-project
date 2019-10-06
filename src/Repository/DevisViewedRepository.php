<?php

namespace App\Repository;

use App\Entity\DevisViewed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisViewed|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisViewed|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisViewed[]    findAll()
 * @method DevisViewed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisViewedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisViewed::class);
    }

    // /**
    //  * @return DevisViewed[] Returns an array of DevisViewed objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DevisViewed
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
