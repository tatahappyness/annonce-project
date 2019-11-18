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

    public function findBySousCategoryId($value, $offset = 0, $limit = 10) 
    {
        if($offset > 0) {
            $limit = $offset * $limit;
        }

        return $this->createQueryBuilder('s')
            ->andWhere('s.prixSousCategoryId = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?ModePrix
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?ModePrix
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

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
