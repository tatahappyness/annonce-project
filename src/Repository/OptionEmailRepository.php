<?php

namespace App\Repository;

use App\Entity\OptionEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OptionEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionEmail[]    findAll()
 * @method OptionEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionEmailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OptionEmail::class);
    }

    // /**
    //  * @return OptionEmail[] Returns an array of OptionEmail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OptionEmail
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
    public function updateNormale()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE `option_email` SET `option_email`.`typekey` = "1" ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();    
    }

    
    
    public function updateOne()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE `option_email` SET `option_email`.`typekey` = "2" ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();    
    }
    
    
    public function updateMore()
    {
        $conn = $this->getEntityManager()->getConnection();

        
        $sql = 'UPDATE `option_email` SET `option_email`.`typekey` = "3" ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();    
    }

}
