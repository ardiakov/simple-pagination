<?php

declare(strict_types=1);

namespace Ardiakov\Pagination\DataProviders;

interface DataProvider
{
    /**
     * Общее количество записей
     *
     * @return int
     */
    public function count(): int;

    /**
     * Получение списка записей для конкретной страницы
     *
     * @param int $offset
     * @param int $perPage
     *
     * @return iterable
     */
    public function result(int $offset, int $perPage): iterable;
}