<?php

namespace PARTest\Core\Helper;

use PAR\Core\Exception\ClassNotFoundException;
use PAR\Core\Helper\ClassHelper;
use PARTest\Core\Fixtures;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClassHelperTest extends TestCase
{
    public function testCanDetermineIfClassIsDeclaredAbstract(): void
    {
        $this->assertTrue(ClassHelper::isAbstract(Fixtures\AbstractClass::class));
        $this->assertFalse(ClassHelper::isAbstract(self::class));
    }

    public function testCanDetermineIfClassIsDeclaredFinal(): void
    {
        $this->assertTrue(ClassHelper::isFinal(Fixtures\FinalClass::class));
        $this->assertFalse(ClassHelper::isFinal(self::class));
    }

    public function testReturnsReflectionClass(): void
    {
        $reflection = ClassHelper::getReflectionClass(self::class);

        $this->assertInstanceOf(ReflectionClass::class, $reflection);
        $this->assertSame($reflection->getName(), self::class);

        // Test caching
        $this->assertSame(ClassHelper::getReflectionClass(self::class), $reflection);
    }

    public function testThrowsClassNotFoundException(): void
    {
        $this->expectException(ClassNotFoundException::class);
        $this->expectExceptionMessage('Class "\ParTest\Core\Fixtures\BogusClass" not found.');

        ClassHelper::getReflectionClass('\ParTest\Core\Fixtures\BogusClass');
    }
}
