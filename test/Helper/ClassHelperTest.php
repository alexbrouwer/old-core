<?php

namespace PARTest\Core\Helper;

use PAR\Core\Exception\ClassNotFoundException;
use PAR\Core\Helper\ClassHelper;
use PARTest\Core\Fixtures\AbstractClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClassHelperTest extends TestCase
{
    public function testCanDetermineIfClassIsDeclaredAbstract(): void
    {
        $this->assertTrue(ClassHelper::isAbstract(AbstractClass::class));
        $this->assertFalse(ClassHelper::isAbstract(self::class));
    }

    public function testReturnsReflectionClass(): void
    {
        $reflection = ClassHelper::getReflectionClass(self::class);

        $this->assertInstanceOf(ReflectionClass::class, $reflection);
        $this->assertSame($reflection->getName(), self::class);
    }

    public function testThrowsClassNotFoundException(): void
    {
        $this->expectException(ClassNotFoundException::class);
        $this->expectExceptionMessage('Class "\ParTest\Core\Fixtures\BogusClass" not found.');

        ClassHelper::getReflectionClass('\ParTest\Core\Fixtures\BogusClass');
    }
}
