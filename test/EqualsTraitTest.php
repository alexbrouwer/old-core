<?php

declare(strict_types=1);

namespace PARTest\Core;

use PARTest\Core\Fixtures\HashableObject;
use PHPUnit\Framework\TestCase;
use stdClass;

class EqualsTraitTest extends TestCase
{
    /**
     * @test
     */
    public function itCanDetermineEqualityWithSelf(): void
    {
        $instance = new HashableObject('foo');

        $this->assertTrue($instance->equals($instance));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityWithSameHash(): void
    {
        $instance = new HashableObject('foo');
        $other = new HashableObject('foo');

        $this->assertNotSame($instance, $other);
        $this->assertTrue($instance->equals($other));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityWithDifferentHash(): void
    {
        $instance = new HashableObject('foo');
        $other = new HashableObject('bar');

        $this->assertNotSame($instance, $other);
        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityWithDifferentObject(): void
    {
        $instance = new HashableObject('foo');
        $other = new stdClass();

        $this->assertNotSame($instance, $other);
        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itCanDetermineEqualityWithDifferentValueType(): void
    {
        $instance = new HashableObject('foo');
        $other = null;

        $this->assertNotSame($instance, $other);
        $this->assertFalse($instance->equals($other));
    }
}
