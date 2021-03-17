<?php

declare(strict_types=1);

namespace Ardiakov\Pagination;

use Ardiakov\Pagination\DataProviders\DataProvider;
use Ardiakov\Pagination\Exceptions\PageIsOutOfRange;
use Ardiakov\Pagination\Exceptions\PageMustBeAPositiveInteger;

/**
 * Class Pagination.
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class Paginator
{
    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var DataProvider
     */
    private DataProvider $dataProvider;

    /**
     * Pagination constructor.
     */
    public function __construct(int $perPage, int $currentPage, DataProvider $dataProvider)
    {
        $this->perPage      = $perPage;
        $this->currentPage  = $currentPage;
        $this->dataProvider = $dataProvider;
    }

    /**
     * Общее количество записей
     *
     * @return int
     */
    public function countResult(): int
    {
        return $this->dataProvider->count();
    }

    /**
     * @throws PageIsOutOfRange
     * @throws PageMustBeAPositiveInteger
     *
     * @return iterable
     */
    public function result(): iterable
    {
        return $this->dataProvider->result($this->offset(), $this->perPage);
    }

    /**
     * @throws PageIsOutOfRange
     * @throws PageMustBeAPositiveInteger
     *
     * @return int
     */
    public function offset(): int
    {
        if ($this->currentPage <= 0) {
            throw new PageMustBeAPositiveInteger();
        }

        if (1 === $this->currentPage) {
            return 0;
        }

        $offset = ($this->currentPage - 1) * $this->perPage;

        if ($this->currentPage > $this->pages()) {
            throw new PageIsOutOfRange();
        }

        return $offset;
    }

    /**
     * Получение количества страниц
     *
     * @return int
     */
    public function pages(): int
    {
        if (0 === $this->dataProvider->count()) {
            return 0;
        }

        return (int) ceil($this->dataProvider->count() / $this->perPage);
    }
}
