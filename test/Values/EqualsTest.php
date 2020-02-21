<?php

declare(strict_types=1);

namespace PARTest\Core\Values;

use PAR\Core\Hashable;
use PAR\Core\Values;
use PHPUnit\Framework\TestCase;

class EqualsTest extends TestCase
{
    /**
     * @test
     */
    public function itCanDetermineEqualityBetweenHashableAndOther(): void
    {
        $b = 'string';

        $a = $this->createMock(Hashable::class);
        $a->expects($this->once())
            ->method('equals')
            ->with($b)
            ->willReturn(false);

        $this->assertFalse(Values::equals($a, $b));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityBetweenOtherAndHashable(): void
    {
        $b = 'string';

        $a = $this->createMock(Hashable::class);
        $a->expects($this->once())
            ->method('equals')
            ->with($b)
            ->willReturn(false);

        $this->assertFalse(Values::equals($b, $a));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityBetweenNonHashables(): void
    {
        $this->assertTrue(Values::equals('foo', 'foo'));

        $this->assertFalse(Values::equals('foo', 'bar'));
        $this->assertFalse(Values::equals(null, 'bar'));
        $this->assertFalse(Values::equals(1, 1.0));
    }

}
