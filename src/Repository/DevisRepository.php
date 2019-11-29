<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Devis::class);
    }

    // /**
    //  * @return Devis[] Returns an array of Devis objects
    //  */

    public function findByZipCodeAndCity($data = null, $limit = 100, $offset = 0)
    {
       
        return $this->createQueryBuilder('d')
                ->where('d.CategoryId IN (?1) AND d.zipCode = ?2 OR d.city = ?3 AND d.CategoryId IN (?4)')
                ->setParameters($data)
                ->orderBy('d.id', 'DESC')
                ->setFirstResult( $offset )
                ->setMaxResults( $limit )
                ->getQuery()
                ->getResult();
    }

    public function findByEmail($data = null, $limit = 100, $offset = 0)
    {
       
        return $this->createQueryBuilder('d')
                ->where('d.email = ?1')
                ->setParameters($data)
                ->orderBy('d.id', 'DESC')
                ->setFirstResult( $offset )
                ->setMaxResults( $limit )
                ->getQuery()
                ->getResult();
    }

    //Get top popular devis, Return array Id articles
    public function findTopPopularDevis(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
                SELECT d.category_id_id AS category_id, COUNT(d.id) AS number_top_devis 
                FROM devis d
                GROUP BY d.category_id_id
                ORDER BY number_top_devis DESC
                LIMIT 10;
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(); // return data array ,not array ogbject

    }

    
    public function findOneById($value): ?Devis
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

    public function findOneByArray(array $criteria, array $orderBy = null): ?Devis
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Devis
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }

}
