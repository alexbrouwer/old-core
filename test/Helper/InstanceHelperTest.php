<?php

namespace PARTest\Tests\Helper;

use PAR\Core\Helper\InstanceHelper;
use PARTest\Core\Fixtures\Integer;
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
}
