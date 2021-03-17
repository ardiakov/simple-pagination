<?php

declare(strict_types=1);

namespace Ardiakov\Pagination\DataProviders;

use Doctrine\ORM\QueryBuilder;

/**
 * Class VacancyApplicationsDataProvider
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class DoctrineOrmDataProvider implements DataProvider
{
    /**
     * @var QueryBuilder
     */
    private QueryBuilder $queryBuilder;

    /**
     * DoctrineDataProvider constructor.
     *
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        $qb = clone $this->queryBuilder;
        $qb->resetDQLParts(['orderBy']);

        $count = $qb
            ->select(sprintf('count(%s)', $qb->getRootAliases()[0]))
            ->setFirstResult(null)
            ->setMaxResults(null)
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return (int) $count;
    }

    /**
     * @inheritDoc
     */
    public function result(int $offset, int $perPage): iterable
    {
        return $this->queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getArrayResult()
            ;
    }
}