<?php

namespace Caesar\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BorrowingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BorrowingRepository extends EntityRepository {

  public function getCurrentBorrowingsFromToSortBy($page, $sort, $direction, $user = null, $resource = null) {
    $nb_per_page = 10;
    $min = ($page - 1) * $nb_per_page;
    $qb = $this->createQueryBuilder('b');
    if ($user != null) {
      $qb->where('b.user = ' . $user->getId());
      if ($resource != null) {
        $qb->andWhere('b.resource = ' . $resource->getId());
      }
    }

    if ($resource != null) {
      $qb->where('b.resource = ' . $resource->getId());
    }
    $qb->orderBy('b.' . $sort, $direction)
      ->setFirstResult($min)
      ->setMaxResults($nb_per_page);
    return $qb->getQuery()->getResult();
  }

  public function count() {
    $qb = $this->createQueryBuilder('b');
    $qb->select('count(b.id)');

    return $qb->getQuery()->getSingleScalarResult();
  }

}
