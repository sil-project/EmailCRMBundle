<?php

namespace Librinfo\EmailCRMBundle\Entity\Repository;

use Librinfo\CRMBundle\Entity\Repository\OrganismRepository as BaseOrganismRepository;

class OrganismRepository extends BaseOrganismRepository
{
    /**
     * @param string $id  the Organism id
     */
    public function getEmailMessagesQueryBuilder($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('e');
        $qb->select('e')
            ->from('LibrinfoEmailBundle:Email', 'e')
            ->leftJoin ('e.organisms', 'org')
            ->leftJoin ('e.positions', 'pos')
            ->where('org.id = :id')
            ->orWhere($qb->expr()->andX(
                $qb->expr()->eq('pos.individual', ':id'),
                $qb->expr()->isNotNull('pos.id')))
            ->setParameter('id', $id)
        ;
        return $qb;
    }
}