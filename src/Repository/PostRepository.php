<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    
    public function findAllPost($limit = 50, $offset = 0)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function filterByCategoryOrCityOrZipcodeOrDepartement($data = null, $offset = 0, $limit = 15)
    {
        if($offset > 0) {
            $limit = $limit * $offset;
        }

        return $this->createQueryBuilder('p')
            ->where('p.CategoryId IN (?1) OR p.CategoryId IN (?2) AND p.city = ?3 OR p.CategoryId IN (?4) AND p.postZipcode = ?5')
            ->setParameters($data)
            ->orderBy('p.id', 'DESC')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByUser($data = null, $limit = 100, $offset = 0)
    {
        return $this->createQueryBuilder('p')
            ->where('p.postUserId = ?1')
            ->setParameters($data)
            ->orderBy('p.id', 'DESC')
            // ->setFirstResult( $offset )
            // ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    
    public function findByEmail($data = null, $limit = 100, $offset = 0)
    {
        return $this->createQueryBuilder('p')
            ->where('p.email = ?1')
            ->setParameter($data)
            ->orderBy('p.id', 'DESC')
            // ->setFirstResult( $offset )
            // ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    
    public function findOneById($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?Post
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Post
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
