<?php

namespace App\Repository;

use App\Entity\CatalogueSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CatalogueSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatalogueSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatalogueSite[]    findAll()
 * @method CatalogueSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogueSiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CatalogueSite::class);
    }

    // /**
    //  * @return CatalogueSite[] Returns an array of CatalogueSite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatalogueSite
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?CatalogueSite
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?CatalogueSite
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
