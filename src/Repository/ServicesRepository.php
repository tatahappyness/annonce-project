<?php

namespace App\Repository;

use App\Entity\Services;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Services|null find($id, $lockMode = null, $lockVersion = null)
 * @method Services|null findOneBy(array $criteria, array $orderBy = null)
 * @method Services[]    findAll()
 * @method Services[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Services::class);
    }

    // /**
    //  * @return Services[] Returns an array of Services objects
    //  */
    public function findByUser($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.userId = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(200)
            ->getQuery()
            ->getResult()
        ;
    }

    

    public function findByCategoryId($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.categoryId = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(200)
            ->getQuery()
            ->getResult()
        ;
    }

    

    public function findByUserAndCategoryId($value): ?Services
    {
        return $this->createQueryBuilder('s')
            ->where('s.userId = ?1 AND s.categoryId = ?2')
            ->setParameters($value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function updateServiceActived()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE `services` SET `services`.`is_actived`= 1';

        $stmt = $conn->prepare($sql);
        $stmt->execute();    
    }

    
    public function updateServiceDisable()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE `services` SET `services`.`is_actived`= 0';

        $stmt = $conn->prepare($sql);
        $stmt->execute();    
    }

    public function updateServiceActivedByUserIdAndCategoryId($userId, $categoryId)
    {
        
        
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE `services` SET `services`.`is_actived`= 1 WHERE  `services`.`user_id_id` = $userId and  `services`.`category_id_id` = $categoryId ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();    

        
    }
    
    public function updateService_one_Actived($value) 
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = " UPDATE `services` SET `is_actived` = '1' WHERE `services`.`id` = $value ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();    

        /*
        $conn = $this->getEntityManager()->getConnection();

        $query = $this->_em->createQuery(" UPDATE services SET is_actived IN '1' WHERE services.id IN :val  ");
            
        
        $query->setParameter('val', $value);

        //$q = $_em->createQuery("UPDATE s SET is_actived IN '1' WHERE id IN :val")
          //      ->setParameter(':val', $value);
        
        //return  $q->execute();

        $stmt = $conn->prepare($query);
        $stmt->execute();    */
    }
    


    
    public function updateSetIdService_Disable($value)
    {
        //$conn = $this->getEntityManager()->getConnection();

        /*
        $query = $this->_em->createQuery(' UPDATE `services` SET `is_actived` = NULL WHERE `services`.`id` = :val ');
        $query->setParameter('val', $value);

        return $query->execute();

        */
        

        
        $conn = $this->getEntityManager()->getConnection();

        $sql = " UPDATE `services` SET `is_actived` = '0' WHERE `services`.`id` = $value ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();    
        
    }



    public function findOneById($value): ?Services
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAllArray(): ?Array
    {
        return $this->findAll();
    }

    public function findOneByArray(array $criteria, array $orderBy = null): ?Services
    {
        return $this->findOneBy($criteria, $orderBy);
    }
    
    public function findById($id, $lockMode = null, $lockVersion = null): ?Services
    {
        return $this->find($id);
    }

    public function findByArray(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?Array
    {
        return $this->findBy($criteria, $orderBy = null, $limit = null, $offset = null);
    }
}
