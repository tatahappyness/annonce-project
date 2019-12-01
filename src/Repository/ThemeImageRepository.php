<?php

namespace App\Repository;

use App\Entity\ThemeImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ThemeImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThemeImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThemeImage[]    findAll()
 * @method ThemeImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ThemeImage::class);
    }

    
    public function findById($id, $lockMode = null, $lockVersion = null): ?ThemeImage
    {
        return $this->find($id);
    }

    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?ThemeImage
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }


    // /**
    //  * @return ThemeImage[] Returns an array of ThemeImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ThemeImage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
