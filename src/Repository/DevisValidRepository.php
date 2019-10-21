<?php

namespace App\Repository;

use App\Entity\DevisValid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisValid|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisValid|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisValid[]    findAll()
 * @method DevisValid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisValidRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisValid::class);
    }

    // /**
    //  * @return DevisValid[] Returns an array of DevisValid objects
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

    public function findByDevisAcceptIdList($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.devisAcceptId IN (?1)')
            ->setParameters($value)
            ->orderBy('d.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByDevisAcceptId($value): ?DevisValid
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.devisAcceptId = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findOneBySomeField($value): ?DevisValid
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?DevisValid
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?DevisValid
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
