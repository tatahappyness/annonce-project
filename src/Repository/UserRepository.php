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
    
	
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?User
    {
        return $this->find($id);
    }
	
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

    //Find by token
    public function findOneByToken($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.token = :val')
            ->setParameter('val', $value)
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
    
    
    public function findAllProfessionalsIstrue()
    {
        return $this->createQueryBuilder('u')
            ->where('u.isProfessional = ?1')
            ->setParameters(array(1=> true))
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
	
	//SELECT * FROM `user` WHERE `user`.`roles` = '["ROLE_USER_PROFESSIONAL"]'

    public function findRolesPro()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')			
            ->andWhere('u.roles = :val')			
            ->setParameter('val', '["ROLE_USER_PROFESSIONAL"]')
            ->getQuery()
            ->getResult();
    }
	
	
    public function findRolesPart()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')			
            ->andWhere('u.roles = :val')			
            ->setParameter('val', '["ROLE_USER_PARTICULAR"]')
            ->getQuery()
            ->getResult();
    }
	
	
    public function findAllProfessionals($data = null, $offset = 0, $limit = 15)
    {

        if ($data == null) {
            return $this->createQueryBuilder('u')
            ->where('u.isProfessional = ?1')
            ->setParameters(array(1=> true))
            ->orderBy('u.id', 'DESC')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        }

        if($offset > 0) {
            $offset = $offset * $limit;
        }

        return $this->createQueryBuilder('u')
            ->where('u.isProfessional = ?1 AND u.userCategoryActivity = ?2 AND u.zipCode LIKE ?3')
            ->setParameters($data)
            ->orderBy('u.id', 'DESC')
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
