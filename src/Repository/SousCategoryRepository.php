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
    
    public function findByCategoryId($value, $offset = 0, $limit = 10) 
    {
        if($offset > 0) {
            $limit = $offset * $limit;
        }

        return $this->createQueryBuilder('s')
            ->andWhere('s.catSousCategoryId = :val')
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

    public function findOneByArray(array $criteria, array $orderBy = null): ?SousCategory
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?SousCategory
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }
    

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
