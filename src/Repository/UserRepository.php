<?php

namespace App\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function find5best()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u.username, u.id, SUM(r.rating) AS ratings
                FROM App:User AS u
                JOIN App:recipe AS r WHERE r.author=u.id

                GROUP BY r.author
                ORDER BY ratings DESC'
            )
            ->setMaxResults(5)
            ->getResult();
    }
}
