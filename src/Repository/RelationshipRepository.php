<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Type;
use App\Entity\Post;
use App\Entity\Devis;
use App\Entity\Customer;
use App\Entity\User;
use App\Entity\Offer;
use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RelationshipRepository
{
    
 
    //public function join($join, $alias, $conditionType = null, $condition = null, $indexBy = null);
    // public function innerJoin($join, $alias, $conditionType = null, $condition = null, $indexBy = null);
    // public function leftJoin($join, $alias, $conditionType = null, $condition = null, $indexBy = null);
    // Example - $qb->leftJoin('u.Phonenumbers', 'p', Expr\Join::WITH, $qb->expr()->eq('p.area_code', 55))
    // Example - $qb->leftJoin('u.Phonenumbers', 'p', 'WITH', 'p.area_code = 55', 'p.id')
    //$qb->where($qb->expr()->andX($qb->expr()->eq('u.firstName', '?1'), $qb->expr()->eq('u.surname', '?2')))
    //$qb->setParameters(array(1 => 'value for ?1', 2 => 'value for ?2')); //$bq->getType() 
    //$offset = (int)$_GET['offset']; $limit = (int)$_GET['limit'];
    //->setFirstResult( $offset ); ->setMaxResults( $limit );

    // "SELECT u FROM User u WHERE u.id = ? ORDER BY u.name ASC"
    // using QueryBuilder string support
    // $qb->add('select', 'u')
    // ->add('from', 'User u')
    // ->add('where', 'u.id = ?1')
    // ->add('orderBy', 'u.name ASC');


}
