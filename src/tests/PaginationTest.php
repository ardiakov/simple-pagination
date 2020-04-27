<?php

declare(strict_types=1);

namespace Ardiakov\Pagination\Tests;

use Ardiakov\Pagination\Exceptions\PageIsOutOfRange;
use Ardiakov\Pagination\Exceptions\PageMustBeAPositiveInteger;
use Ardiakov\Pagination\Pagination;
use PHPUnit\Framework\TestCase;

/**
 * Class PaginationTest.
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
class PaginationTest extends TestCase
{
    /**
     * @dataProvider dataProviderMain
     */
    public function test(int $perPage, int $currentPage, int $totalItems, int $expectedOffset, int $expectedCountPages): void
    {
        $pagination = new Pagination($perPage, $currentPage, $totalItems);
        $this->assertEquals($expectedOffset, $pagination->offset());
        $this->assertEquals($expectedCountPages, $pagination->pages());
    }

    public function dataProviderMain(): array
    {
        return [
            [10, 1, 100, 0, 10],
            [10, 4, 100, 30, 10],
            [10, 3, 101, 20, 11],
        ];
    }

    /**
     * @dataProvider pageMustBeAPositiveIntegerExceptionDataProvider
     */
    public function testPageMustBeAPositiveIntegerException(int $perPage, int $currentPage, int $totalItems): void
    {
        $this->expectException(PageMustBeAPositiveInteger::class);
        (new Pagination($perPage, $currentPage, $totalItems))->offset();
    }

    public function pageMustBeAPositiveIntegerExceptionDataProvider(): array
    {
        return [
            [10, 0, 101],
            [10, -1, 101],
        ];
    }

    public function testPageIsOutOfRangeException(): void
    {
        $this->expectException(PageIsOutOfRange::class);
        (new Pagination(10, 12, 101))->offset();
    }
}
