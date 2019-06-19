<?php

namespace PAR\Core\Tests;

use PAR\Core\ComparableInterface;
use PAR\Core\Comparator;
use PAR\Core\Exception\ClassCastException;
use PAR\Core\Tests\Fixtures\Integer;
use PHPUnit\Framework\TestCase;

class ComparableInterfaceTest extends TestCase
{
    public function testComparableImplementationReturnsZeroOnEquality(): void
    {
        $value = Integer::fromNative(3);
        $other = Integer::fromNative(3);

        $this->assertSame($value->compareTo($other), 0);
        $this->assertSame($other->compareTo($value), 0);
    }

    public function testComparableImplementationReturnsPositiveIntegerWhenComparedToSmaller(): void
    {
        $value = Integer::fromNative(3);
        $other = Integer::fromNative(2);

        $this->assertSame($value->compareTo($other), 1);
    }

    public function testComparableImplementationReturnsNegativeIntegerWhenComparedToLarger(): void
    {
        $value = Integer::fromNative(3);
        $other = Integer::fromNative(4);

        $this->assertSame($value->compareTo($other), -1);
    }

    public function testComparableImplementationThrowsClassCastExceptionWhenWrongType(): void
    {
        $value = Integer::fromNative(3);
        $other = new class implements ComparableInterface
        {
            public function compareTo(ComparableInterface $other): int
            {
                return 0;
            }
        };

        $this->expectException(ClassCastException::class);
        $this->expectExceptionMessage('Type ' . get_class($other) . ' is unsupported, expected ' . Integer::class);

        $value->compareTo($other);
    }

    public function testComparableImplementationCanBeUsedAsSortCallback(): void
    {
        $list = [
            Integer::fromNative(3),
            Integer::fromNative(2),
            Integer::fromNative(1),
            Integer::fromNative(4),
            Integer::fromNative(2),
        ];

        uasort($list, Comparator::callback());

        $sorted = array_map(
            static function (Integer $int) {
                return $int->toNative();
            }, $list
        );

        $expected = [
            2 => 1,
            1 => 2,
            4 => 2,
            0 => 3,
            3 => 4,
        ];

        $this->assertSame($expected, $sorted);
    }
}
