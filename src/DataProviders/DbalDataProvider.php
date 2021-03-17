<?php

declare(strict_types=1);

namespace Ardiakov\Pagination\DataProviders;

use Doctrine\DBAL\Connection;

/**
 * Class DbalDataProvider
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class DbalDataProvider implements DataProvider
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * Основной запрос по которому будет происходить пагинация
     *
     * @var string
     */
    private string $sql;

    /**
     * @var int
     */
    private int $countedRows;

    /**
     * DbalDataProvider constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection, string $sql, int $countedRows)
    {
        $this->connection  = $connection;
        $this->sql         = $sql;
        $this->countedRows = $countedRows;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->countedRows;
    }

    /**
     * @inheritDoc
     */
    public function result(int $offset, int $perPage): iterable
    {
        $sql = $this->sql . "
            LIMIT " . $this->connection->quote($perPage) . "
            OFFSET " . $this->connection->quote($offset) . "
        ";

        return $this->connection->fetchAll($sql);
    }
}