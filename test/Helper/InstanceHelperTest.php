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
        $this->assertTrue(InstanceHelper::isOfClass(Integer::fromNative(1), Integer::class));
    }

    public function testIsOfClassWithDifferentInstanceIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfClass(new stdClass(), Integer::class));
    }

    public function testIsOfClassWithNonObjectIsFalsy(): void
    {
        $this->assertFalse(InstanceHelper::isOfClass(Integer::class, 'string'));
    }
}
