<?php

namespace AppBundle\Entity\Repository;

use BaseBundle\Entity\Repository\AbstractRepository;

class CommentRepository extends AbstractRepository
{

    public function getQueryBuilder($parameters = null, $execute = true)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
            ->from($this->getClassName(), 'e')
        ;

        if (array_key_exists('sort', $parameters) and !empty($parameters['sort'])) {
            foreach ($parameters['sort'] as $sortConfig) {

                $qb->addOrderBy("e.${sortConfig['field']}", $sortConfig['direction']);
            }
        }
        return $execute === true ? $qb->getQuery()
            ->getResult()
            : $qb;
    }
}
