<?php

namespace App\Repository;

use App\Entity\Configsite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Configsite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Configsite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Configsite[]    findAll()
 * @method Configsite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigsiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Configsite::class);
    }

    // /**
    //  * @return Configsite[] Returns an array of Configsite objects
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

    public function findOneByIsActive($value = true): ?Configsite
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.isActive = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneById($value): ?Configsite
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?Configsite
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Configsite
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
