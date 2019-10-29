<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */

    public function findAllArticles($limit = 20)
    {
        return $this->createQueryBuilder('a')
           ->orderBy('a.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByCategory($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.articleCategId = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            //->setMaxResults(200)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCategoryArray($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.articleCategId IN (?1)')
            ->setParameters($value)
            ->orderBy('a.id', 'ASC')
           // ->setMaxResults(200)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneById($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?Article
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Article
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
