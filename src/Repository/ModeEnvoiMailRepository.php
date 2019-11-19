<?php

namespace App\Repository;

use App\Entity\ModeEnvoiMail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModeEnvoiMail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeEnvoiMail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeEnvoiMail[]    findAll()
 * @method ModeEnvoiMail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeEnvoiMailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModeEnvoiMail::class);
    }

    // /**
    //  * @return ModeEnvoiMail[] Returns an array of ModeEnvoiMail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModeEnvoiMail
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
