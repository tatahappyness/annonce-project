<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    // /**
    //  * @return Comments[] Returns an array of Comments objects
    //  */
    
    public function findAllCommentsByParticular($limit = null)
    {
       if($limit !== null) {

        return $this->createQueryBuilder('c')
        ->andWhere('c.isParticular = ?1 AND c.isPublish = ?2')
        ->setParameters(array(1=> true, 2=> true))
        ->orderBy('c.id', 'ASC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();

       }
       return $this->createQueryBuilder('c')
       ->andWhere('c.isParticular = ?1 AND c.isPublish = ?2')
       ->setParameters(array(1=> true, 2=> true))
       ->orderBy('c.id', 'ASC')
       //->setMaxResults($limit)
       ->getQuery()
       ->getResult();
        
    }

    public function findAllCommentsByPros($limit = null)
    {
       
        if ($limit !== null) {
            
            return $this->createQueryBuilder('c')
                ->andWhere('c.isPro = ?1 AND c.isPublish = ?2')
                ->setParameters(array(1=> true, 2=> true))
                ->orderBy('c.id', 'ASC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
            ;

        }
        return $this->createQueryBuilder('c')
            ->andWhere('c.isPro = ?1 AND c.isPublish = ?2')
            ->setParameters(array(1=> true, 2=> true))
            ->orderBy('c.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        ;
        
    }
    

    public function findOneById($value): ?Comments
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

    public function findOneByArray(array $criteria, array $orderBy = null): ?Comments
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Comments
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
