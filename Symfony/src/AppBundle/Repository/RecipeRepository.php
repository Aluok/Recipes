<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Recipe;

/**
 * RecipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipeRepository extends \Doctrine\ORM\EntityRepository
{

    public function find5mostViewed()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r.title, r.slug
                FROM AppBundle:recipe AS r
                WHERE r.published=1 AND r.finished=1
                ORDER BY r.views DESC'
            )
            ->setMaxResults(5)
            ->getResult();
    }

    public function find5bestRated()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r.title, r.slug
                FROM AppBundle:recipe AS r
                WHERE r.published=1 AND r.finished=1
                ORDER BY r.rating DESC'
            )
            ->setMaxResults(5)
            ->getResult();
    }

    public function getListPublished($categories, int $page, $sorter, string $direction = 'ASC')
    {
        return $this->getList($categories, $page)
            ->andWhere('r.published = 1')
            ->orderBy('r.' . $sorter, $direction)
            ->getQuery()
            ->getResult();
    }

    public function getListForReview($categories, int $page, $sorter, string $direction = 'ASC')
    {
        return $this->getList($categories, $page)
            ->andWhere('r.published = 0')
            ->andWhere('r.finished = 1')
            ->orderBy('r.' . $sorter, $direction)
            ->getQuery()
            ->getResult();
    }

    private function getList($filters, $page)
    {
        $query = $this->createQueryBuilder('r');
        if ($filters !== null) {
            if (array_key_exists('category', $filters) && count($filters['category']) != 0) {
                $query->add('where', $query->expr()->in('r.category', '?1'))
                    ->setParameter('1', $filters['category']);
            }
            if (array_key_exists('ingredients', $filters) && count($filters['ingredients']) != 0) {
                $query->join('AppBundle\Entity\Ingredient', 'i')
                    ->add('where', $query->expr()->in('i.name', '?1'))
                //
                // $query->add('where', $query->expr()->in('r.category', '?1'))
                    ->setParameter('1', $filters['ingredients'])
                    ->andWhere('i.recipe = r.slug');
            }
        }
        return $query
            ->setFirstResult(($page - 1) * Recipe::NB_RECIPE_PAGE)
            ->setMaxResults(Recipe::NB_RECIPE_PAGE);
    }

    public function getCount($published, $filters)
    {
        $query = $this
            ->createQueryBuilder('r')
            ->select('COUNT(r.title)');
        if ($published) {
            $query->where("r.published = 1");
        } else {
            $query->where("r.published = 0")
                ->andWhere("r.finished = 1");
        }
        if ($filters !== null) {
            if (array_key_exists('category', $filters) && count($filters['category']) != 0) {
                $query->add('where', $query->expr()->in('r.category', '?1'))
                    ->setParameter('1', $filters['category']);
            }
            if (array_key_exists('ingredients', $filters) && count($filters['ingredients']) != 0) {
                $query->join('AppBundle\Entity\Ingredient', 'i')
                    ->add('where', $query->expr()->in('i.name', '?1'))
                //
                // $query->add('where', $query->expr()->in('r.category', '?1'))
                    ->setParameter('1', $filters['ingredients'])
                    ->andWhere('i.recipe = r.slug');
            }
        }
        return ceil($query->getQuery()->getOneOrNullResult()[1] / Recipe::NB_RECIPE_PAGE);
    }

    public function getUniqueCategories()
    {
        return $this
            ->createQueryBuilder('r')
            ->select('r.category')
            ->groupBy('r.category')
            ->getQuery()->getResult();
    }
}
