<?php

namespace App\Repository;

use App\Entity\DevisAccept;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisAccept|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisAccept|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisAccept[]    findAll()
 * @method DevisAccept[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisAcceptRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisAccept::class);
    }

    // /**
    //  * @return DevisAccept[] Returns an array of DevisAccept objects
    //  */
 
    public function findByUserId($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.userId = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    //find by user id and devis id
    public function findByUserIdAndDevisId($value) : ?DevisAccept
    {
        return $this->createQueryBuilder('d')
            ->where('d.userId = ?1 AND d.devisId = ?2')
            ->setParameters($value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByDevisIdList($value)
    {
        return $this->createQueryBuilder('d')
            ->where('d.devisId IN (?1)')
            ->setParameters($value)
            ->orderBy('d.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByDevisId($value, $limit = 100, $offset = null)
    {
        return $this->createQueryBuilder('d')
            ->where('d.devisId = ?1')
            ->setParameters($value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
  
    public function findOneById($value): ?DevisAccept
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?DevisAccept
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?DevisAccept
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
