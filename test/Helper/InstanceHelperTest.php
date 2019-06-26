<?php

namespace PARTest\Tests\Helper;

use PAR\Core\Exception\ClassCastException;
use PAR\Core\Helper\InstanceHelper;
use PARTest\Core\Fixtures\Integer;
use PHPUnit\Framework\TestCase;
use stdClass;

class InstanceHelperTest extends TestCase
{
    public function testIsOfClassWithClassInstanceIsTruthy(): void
    {
        $this->assertTrue(InstanceHelper::isOfClass(Integer::fromNative(1), Integer::class));
    }

    public function testIsOfClassWithDifferentInstanceIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfClass(new stdClass(), Integer::class));
    }

    public function testIsOfClassWithNonObjectIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfClass('string', Integer::class));
    }

    public function testAssertIsOfClassThrowsClassCastException(): void
    {
        $this->expectException(ClassCastException::class);

        InstanceHelper::assertIsOfClass('not an instance', static::class);
    }

    public function testCanTransformInstanceToString(): void
    {
        $this->assertSame(sprintf('%s@%s', get_class($this), spl_object_hash($this)), InstanceHelper::toString($this));
    }

    public function testCanDetermineIfAnObjectExistsInListByStringComparison(): void
    {
        $instance = new stdClass();
        $list = [new stdClass(), $instance];

        $this->assertTrue(InstanceHelper::isAnyOf($instance, $list));
        $this->assertFalse(InstanceHelper::isAnyOf(new stdClass(), $list));
    }

    public function testCanDetermineIfAnObjectExistsInListByObjectInterfaceEquals(): void
    {
        $instance = Integer::fromNative(1);
        $list = [Integer::fromNative(2), $instance];

        $this->assertTrue(InstanceHelper::isAnyOf($instance, $list));
        $this->assertFalse(InstanceHelper::isAnyOf(Integer::fromNative(3), $list));
    }
}
