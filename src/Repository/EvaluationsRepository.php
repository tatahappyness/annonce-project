<?php

namespace App\Repository;

use App\Entity\Evaluations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evaluations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluations[]    findAll()
 * @method Evaluations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evaluations::class);
    }

    // /**
    //  * @return Evaluations[] Returns an array of Evaluations objects
    //  */
    
    public function findByUser($value)
    {
        return $this->createQueryBuilder('e')
            ->where('e.userProId = ?1')
            ->setParameters($value)
            ->orderBy('e.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    public function findOneByUserProAndPart($value): ?Evaluations
    {
        return $this->createQueryBuilder('e')
            ->where('e.userProId = ?1 AND e.userPartId = ?2')
            ->setParameters($value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
