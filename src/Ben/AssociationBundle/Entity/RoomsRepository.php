<?php

namespace Ben\AssociationBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * RoomsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoomsRepository extends EntityRepository
{
	public function getFloors()
	{
		 $qb = $this->createQueryBuilder('r')
		 		->select('distinct(r.floor)')
		 		->getQuery();
		 
		 return $qb->getArrayResult();
	}
    public function findSome($nombreParPage, $page, $keyword, $number, $floor, $bedNumber, $gender, $status) {   
    // var_dump($keyword, $number, $floor, $status);die();    
       $qb = $this->createQueryBuilder('r')
                ->leftJoin('r.hotel', 'h')
                ->addSelect('h')
                ->andWhere('h.name like :keyword or h.city like :keyword or h.description like :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');

        if(!empty($number)){
        	$qb->andWhere('r.number = :number')
               ->setParameter('number', $number);
        }
        if(!empty($floor)){
        	$qb->andWhere('r.floor = :floor')
               ->setParameter('floor', $floor);
        }
        if(!empty($bedNumber)){
          $qb->andWhere('r.max_persons = :max_persons')
               ->setParameter('max_persons', $bedNumber);
        }
        if(!empty($gender)){
          $qb->andWhere('r.type = :type')
               ->setParameter('type', $gender);
        }
        if(!empty($status)){
        	$qb->andWhere('r.status = :status')
               ->setParameter('status', $status);
        }
                
        $qb->setFirstResult(($page - 1) * $nombreParPage)
        ->setMaxResults($nombreParPage);
        
       return new Paginator($qb->getQuery());
    }

    public function counter() {
        $query = $this->_em->createQuery('SELECT count(r) FROM ben\AssociationBundle\Entity\Rooms r');
        return $query->getOneOrNullResult();
    } 
	
}
