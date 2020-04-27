<?php

declare(strict_types=1);

namespace Ardiakov\Pagination;

use Ardiakov\Pagination\Exceptions\PageIsOutOfRange;
use Ardiakov\Pagination\Exceptions\PageMustBeAPositiveInteger;

/**
 * Class Pagination.
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class Pagination
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
     * @var int
     */
    private $totalItems;

    /**
     * Pagination constructor.
     */
    public function __construct(int $perPage, int $currentPage, int $totalItems = 0)
    {
        $this->perPage     = $perPage;
        $this->currentPage = $currentPage;
        $this->totalItems  = $totalItems;
    }

    /**
     * @throws PageIsOutOfRange
     * @throws PageMustBeAPositiveInteger
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

    public function pages(): int
    {
        if (0 === $this->totalItems) {
            return 0;
        }

        return (int)ceil($this->totalItems / $this->perPage);
    }

    public function maxResults(): int
    {
        return $this->perPage;
    }
}
