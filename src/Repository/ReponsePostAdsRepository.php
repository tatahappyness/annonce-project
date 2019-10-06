<?php

namespace App\Repository;

use App\Entity\ReponsePostAds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReponsePostAds|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponsePostAds|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponsePostAds[]    findAll()
 * @method ReponsePostAds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponsePostAdsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReponsePostAds::class);
    }

    // /**
    //  * @return ReponsePostAds[] Returns an array of ReponsePostAds objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReponsePostAds
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
