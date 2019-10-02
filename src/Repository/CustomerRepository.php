<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
* @method Customer|null find($id, $lockMode = null, $lockVersion = null)
* @method Customer|null findOneBy(array $criteria, array $orderBy = null)
* @method Customer[]    findAll()
* @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    // /**
    //  * @return Customer[] Returns an array of Customer objects
    //  */
   
    public function findByUser( $user = null ) : ?Customer
    {
        $custom = $this->createQueryBuilder('c')
            ->andWhere('c.userId = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult();
        if (!is_null($custom)) {
           
            return $custom;

        }
        return null;
    }
    

    public function findOneById($value): ?Customer
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

    public function findOneByArray(array $criteria, array $orderBy = null): ?Customer
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Customer
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
