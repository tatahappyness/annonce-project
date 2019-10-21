<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User of User object
    //  */
    
    public function findOneByEmail($value)
    {   
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $value)
            //->orderBy('u.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneById($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findNewsProfessionals($limit = 10, $offset = 0)
    {
        return $this->createQueryBuilder('u')
            ->where('u.isProfessional = ?1')
            ->setParameters(array(1=> true))
            ->orderBy('u.id', 'DESC')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findAllProfessionals($data = null, $limit = 50, $offset = 0)
    {

        if ($data == null) {
            return $this->createQueryBuilder('u')
            ->where('u.isProfessional = ?1')
            ->setParameters(array(1=> true))
            ->orderBy('u.id', 'ASC')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        }

        return $this->createQueryBuilder('u')
            ->where('u.isProfessional = 1? AND u.userCategoryActivity = ?2 AND u.userCity = ?3 OR u.userCategoryActivity = ?4 AND u.isProfessional = 5?')
            ->setParameters($data)
            ->orderBy('u.id', 'ASC')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }


    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }
    
}
