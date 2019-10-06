<?php

namespace App\Repository;

use App\Entity\Labels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Labels|null find($id, $lockMode = null, $lockVersion = null)
 * @method Labels|null findOneBy(array $criteria, array $orderBy = null)
 * @method Labels[]    findAll()
 * @method Labels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Labels::class);
    }

    // /**
    //  * @return Labels[] Returns an array of Labels objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Labels
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
