<?php

namespace App\Repository;

use App\Entity\Abonnement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Abennement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abennement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abennement[]    findAll()
 * @method Abennement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Abonnement::class);
    }

    // /**
    //  * @return Abonnement[] Returns an array of Abonnement objects
    //  */
    
    public function isPremiumAndDateExpireValid( $criticals = null ) : ?bool
    {
        $abonnement = $this->createQueryBuilder('a')
            ->where('a.customerId = ?1 AND a.serviceId = ?2')
            ->setParameters($criticals)
            ->getQuery()
            ->getOneOrNullResult();
        if (!is_null($abonnement)) {
           //dump($abonnement->getServiceId()->getIsActived());die;
            $datetime1 = $abonnement->getDateExpire();
            $datetime2 = new \DateTime('now');
            $interval = $datetime1->diff($datetime2);
            //$interval->format('%R%a days');
            return (int) ($interval->format('%R%a') < 0 && $abonnement->getServiceId()->getIsActived() == true) ? true : false;

        }
        return false;
    }

    public function findOneByCustomerAndService($value): ?Abonnement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.customerId = ?1 AND a.serviceId = ?2')
            ->setParameters($value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findOneById($value): ?Abonnement
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

    public function findOneByArray(array $criteria, array $orderBy = null): ?Abonnement
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Abonnement
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }
   
}
