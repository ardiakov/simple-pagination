<?php

declare(strict_types=1);

namespace Ardiakov\Pagination\Tests;

use Ardiakov\Pagination\DataProviders\DataProvider;
use Ardiakov\Pagination\Exceptions\PageIsOutOfRange;
use Ardiakov\Pagination\Exceptions\PageMustBeAPositiveInteger;
use Ardiakov\Pagination\Paginator;
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
        $dataProvider = $this->createMock(DataProvider::class);
        $dataProvider->method('count')->willReturn($totalItems);
        $dataProvider->method('result')->willReturn([]);

        $pagination = new Paginator($perPage, $currentPage, $dataProvider);
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
        $dataProvider = $this->createMock(DataProvider::class);
        $dataProvider->method('count')->willReturn($totalItems);
        $dataProvider->method('result')->willReturn([]);

        $this->expectException(PageMustBeAPositiveInteger::class);
        (new Paginator($perPage, $currentPage, $dataProvider))->offset();
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
        $dataProvider = $this->createMock(DataProvider::class);
        $dataProvider->method('count')->willReturn(0);
        $dataProvider->method('result')->willReturn([]);

        $this->expectException(PageIsOutOfRange::class);
        (new Paginator(10, 12, $dataProvider))->offset();
    }
}
