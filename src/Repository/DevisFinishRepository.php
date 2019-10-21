<?php

namespace App\Repository;

use App\Entity\DevisFinish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisFinish|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisFinish|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisFinish[]    findAll()
 * @method DevisFinish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisFinishRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisFinish::class);
    }

    // /**
    //  * @return DevisFinish[] Returns an array of DevisFinish objects
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

    public function findByDevisValidIdList($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.devisValid IN (?1)')
            ->setParameters($value)
            ->orderBy('d.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByDevisValidId($value): ?DevisFinish
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.devisValid = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findOneById($value): ?DevisFinish
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

    public function findOneByArray(array $criteria, array $orderBy = null): ?DevisFinish
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?DevisFinish
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
