<?php

namespace PARTest\Core;

use PAR\Core\Comparator;
use PAR\Core\Exception\ClassCastException;
use PARTest\Core\Fixtures\Integer;
use PHPUnit\Framework\TestCase;

class ComparatorTest extends TestCase
{
    public function testSortArrayReturnsListInExpectedOrder(): void
    {
        $list = [
            Integer::fromNative(3),
            Integer::fromNative(2),
            Integer::fromNative(1),
            Integer::fromNative(4),
            Integer::fromNative(2),
        ];
        $sorted = Comparator::sortArray($list);

        $expectedKeyOrder = [2, 1, 4, 0, 3];

        $this->assertSame($expectedKeyOrder, array_keys($sorted));
    }

    public function testSortArrayDoesNotChangeOriginal(): void
    {
        $list = [
            Integer::fromNative(3),
            Integer::fromNative(2),
            Integer::fromNative(1),
            Integer::fromNative(4),
            Integer::fromNative(2),
        ];
        $sorted = Comparator::sortArray($list);

        $this->assertNotSame($list, $sorted);
    }

    public function testThrowsClassCastExceptionWhenArrayContainsUnexpectedType(): void
    {
        $list = [
            Integer::fromNative(3),
            null,
        ];

        $this->expectException(ClassCastException::class);

        Comparator::sortArray($list);
    }
}
