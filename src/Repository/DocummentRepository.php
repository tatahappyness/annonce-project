<?php

namespace App\Repository;

use App\Entity\Documment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Documment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Documment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Documment[]    findAll()
 * @method Documment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocummentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Documment::class);
    }

    // /**
    //  * @return Documment[] Returns an array of Documment objects
    //  */
    
    public function findByUserId($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.userId = ?1')
            ->setParameters($value)
            ->orderBy('d.id', 'ASC')
           // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Documment
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
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

    public function findOneByArray(array $criteria, array $orderBy = null): ?Documment
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Documment
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
