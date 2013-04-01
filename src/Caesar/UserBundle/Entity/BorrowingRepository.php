<?php

namespace Caesar\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use PDO;

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
      $qb->where('b.user = :user');
      $qb->setParameter("user", $user->getId());
      if ($resource != null) {
        $qb->andWhere('b.resource = :resource');
        $qb->setParameter("resource", $resource->getId());
      }
    }

    if ($resource != null) {
      $qb->where('b.resource = :resource');
      $qb->setParameter("resource", $resource->getId());
    }
    $qb->orderBy('b.' . $sort, $direction)
      ->setFirstResult($min)
      ->setMaxResults($nb_per_page);
    return $qb->getQuery()->getResult();
  }

  public function count($user = null, $resource = null) {
    $qb = $this->createQueryBuilder('b');
    $qb->select('count(b.id)');

    if ($user != null) {
      $qb->where('b.user = :user');
      $qb->setParameter("user", $user->getId());
      if ($resource != null) {
        $qb->andWhere('b.resource = :resource');
        $qb->setParameter("resource", $resource->getId());
      }
    }

    if ($resource != null) {
      $qb->where('b.resource = :resource');
      $qb->setParameter("resource", $resource->getId());
    }

    return $qb->getQuery()->getSingleScalarResult();
  }

  public function getAllBorrowingsFromToSortBy($page, $sort, $direction, $user = null, $resource = null) {
    $nb_per_page = 10;
    $min = ($page - 1) * $nb_per_page;

    $join = "LEFT JOIN resource r ON r.id = resource_id LEFT JOIN user u ON u.id = user_id";

    $query1 = "SELECT b.id, r.description as resource, CONCAT(u.name, ' ', u.firstname) as user, b.borrowingDate, null as returnDate FROM borrowing b ";
    $query1 .= $join;
    $query2 = "SELECT a.id, r.description as resource, CONCAT(u.name, ' ', u.firstname) as user, a.borrowingDate, a.returnDate as returnDate FROM borrowingArchive a ";
    $query2 .= $join;
    $separator = " where ";
    if ($user != null) {
      $query1 .= $separator . "user_id = :user";
      $query2 .= $separator . "user_id = :user";
      $separator = " and ";
    }
    if ($resource != null) {
      $query1 .= $separator . "resource_id = :resource";
      $query2 .= $separator . "resource_id = :resource";
    }

    if ($direction != 'asc' || $direction != 'desc') {
      $direction = 'asc';
    }

    $orderBy = " order by case :sort
           when 'borrowingDate' then borrowingDate
           when 'resource' then resource
           when 'user' then user
           else id
       end $direction";

    $query1 .= $orderBy;
    $query2 .= $orderBy;
    $stmt = $this->_em->getConnection()->prepare("SELECT id, resource, user, borrowingDate, returnDate FROM (( $query1 ) union all ( $query2 )) t $orderBy LIMIT :min , :number");

    if ($user != null) {
      $stmt->bindValue('user', $user->getId());
    }
    if ($resource != null) {
      $stmt->bindValue('resource', $resource->getId());
    }

    $stmt->bindValue('sort', $sort);
    $stmt->bindValue('min', $min, PDO::PARAM_INT);
    $stmt->bindValue('number', $min + $nb_per_page, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll();
  }

}
