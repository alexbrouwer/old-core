<?php

namespace Par\Core\Tests\Helper;

use PAR\Core\Helper\InstanceHelper;
use PAR\Core\Tests\Fixtures\Integer;
use PAR\Core\Tests\Fixtures\Natural;
use PHPUnit\Framework\TestCase;
use stdClass;

class InstanceHelperTest extends TestCase
{
    public function testIsOfClassWithClassInstanceIsTruthy(): void
    {
        $this->assertTrue(InstanceHelper::isOfClass(Integer::class, Integer::fromNative(1)));
    }

    public function testIsOfClassWithDifferentInstanceIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfClass(Integer::class, new stdClass()));
    }

    public function testIsOfClassWithNonObjectIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfClass(Integer::class, 'string'));
    }

    public function testIsOfSameClassAsWithSameClassesIsTruthy(): void
    {
        $this->assertTrue(InstanceHelper::isOfSameClassAs(Integer::fromNative(1), Integer::fromNative(2)));
    }

    public function testIsOfSameClassAsWithOneDifferentClassIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfSameClassAs(Integer::fromNative(1), Integer::fromNative(2), new stdClass()));
    }

    public function testIsOfSameClassAsWithExtendedClassIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfSameClassAs(Integer::fromNative(1), Natural::fromNative(1)));
    }

    public function testIsOfSameClassAsWithNonObjectIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfSameClassAs(Integer::fromNative(1), 'string'));
    }

}
