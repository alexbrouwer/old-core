<?php

namespace PARTest\Core\Tests;

use PAR\Core\ComparableInterface;
use PAR\Core\Exception\ClassCastException;
use PARTest\Core\Fixtures\Integer;
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
        $this->expectExceptionMessage('Expected an instance of PARTest\Core\Fixtures\Integer, got instance of ' . get_class($other));

        $value->compareTo($other);
    }
}
