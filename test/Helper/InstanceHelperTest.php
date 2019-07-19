<?php

namespace PARTest\Tests\Helper;

use PAR\Core\Helper\InstanceHelper;
use PARTest\Core\Fixtures\Integer;
use PHPUnit\Framework\TestCase;
use stdClass;

class InstanceHelperTest extends TestCase
{
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
