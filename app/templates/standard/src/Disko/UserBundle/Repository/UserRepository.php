<?php

/**
 * Repository
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle\Repository;

use Disko\CoreBundle\Repository\BaseRepository;

/**
 * Class UserRepository
 *
 * @package Disko\UserBundle\Repository
 */
class UserRepository extends BaseRepository
{

    /**
     * Get all user query, using for pagination
     *
     * @param array $filters
     *
     * @return mixed
     */
    public function queryForSearch($filters = array())
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.lastName', 'asc');

        if (count($filters) > 0) {
            foreach ($filters as $key => $filter) {
                $qb->andWhere('u.'.$key.' LIKE :'.$key);
                $qb->setParameter($key, '%'.$filter.'%');
            }
        }

        return $qb->getQuery();
    }

    /**
     * Find one for edit profile
     *
     * @param $id
     * @return mixed
     */
    public function findOneToEdit($id)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.id = :id')
            ->setParameter('id', $id);

        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }
}
