<?php

namespace Ben\AssociationBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * configRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class configRepository extends EntityRepository
{
	public function updateBy($key, $value)
    {
        $qB = $this->getEntityManager()->createQueryBuilder()
        	->update('BenAssociationBundle:config', 'c')
            ->set('c.the_value', '?1')
            ->where('c.the_key = ?2')
            ->setParameter(1, $value)
            ->setParameter(2, $key);
         
        return $qB->getQuery()->execute();
    }
	
}
