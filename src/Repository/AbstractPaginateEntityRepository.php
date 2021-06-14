<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

abstract class AbstractPaginateEntityRepository extends ServiceEntityRepository
{
    public function paginate(int $currentPage, int $perPage, $queryBuilder = null): array
    {
        $currentPage = $currentPage < 1 ? 1 : $currentPage;
        $firstResult = ($currentPage - 1) * $perPage;

        $qb = $queryBuilder === null ? $this->createQueryBuilder('p') : $queryBuilder;

        $query = $qb
            ->setFirstResult($firstResult)
            ->setMaxResults($perPage)
            ->getQuery();

        $paginator = new Paginator($query, false);
        $numResults = $paginator->count();

        return [
            'items'       => $paginator->getIterator(),
            'currentPage' => $currentPage,
            'totalPages'  => (int)ceil($numResults / $perPage)
        ];
    }
}
