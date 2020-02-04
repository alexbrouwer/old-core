<?php

declare(strict_types=1);

namespace PARTest\Core;

use PAR\Core\Hashable;
use PAR\Core\Values;
use PHPUnit\Framework\TestCase;
use stdClass;

class ValuesTest extends TestCase
{
    /**
     * @var resource[]
     */
    private $resources = [];

    public function provideValuesWithExpectedHash(): array
    {
        $obj = new stdClass();

        $resource = $this->getResource();

        $closedResource = $this->getResource();
        fclose($closedResource);

        return [
            'string' => ['Hello World!', -969099747],
            'int' => [36, 36],
            'really-large-float' => [1.0365E+36, 2068291429],
            'negative-fraction' => [-0.1, -1110651699],
            'positive-fraction' => [0.1, 1036831949],
            'null' => [null, 0],
            'bool(true)' => [true, 1231],
            'bool(false)' => [false, 1237],
            'object' => [$obj, spl_object_id($obj)],
            'resource' => [$resource, (int)$resource],
            'resource-closed' => [$closedResource, (int)$closedResource],
            'array-list' => [[1, 10], 11],
            'array-map' => [[1 => 'foo', 4 => 'bar'], 198878],
        ];
    }

    /**
     * @test
     * @dataProvider provideValuesWithExpectedHash
     *
     * @param mixed $value
     * @param int $expectedHash
     */
    public function itCanTransformValueToHash($value, $expectedHash): void
    {
        $actualHash = Values::hash($value);

        $this->assertSame($expectedHash, $actualHash);
    }

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
        $this->assertFalse(Values::equals('foo', 'bar'));
        $this->assertTrue(Values::equals('foo', 'foo'));
        $this->assertFalse(Values::equals(null, 'bar'));
        $this->assertFalse(Values::equals(1, 1.0));
    }

    /**
     * @test
     */
    public function itCanDetermineHashOfHashable(): void
    {
        $expected = 12;

        $hashable = $this->createMock(Hashable::class);
        $hashable->expects($this->once())
            ->method('hash')
            ->with()
            ->willReturn($expected);

        $this->assertEquals($expected, Values::hash($hashable));
    }

    public function providedValuesWithExpectedType(): array
    {
        $obj = new stdClass();

        $closedResource = $this->getResource();
        fclose($closedResource);

        return [
            'string' => ['foo', 'string'],
            'int' => [1, 'int'],
            'bool' => [true, 'bool'],
            'null' => [null, 'null'],
            'float' => [0.1, 'float'],
            'array' => [['foo'], 'array'],
            'object' => [$obj, get_class($obj)],
            'closure' => [
                static function () {
                },
                'closure',
            ],
            'resource' => [$this->getResource(), 'resource'],
            'resource (closed)' => [$closedResource, 'resource'],
        ];
    }

    /**
     * @test
     * @dataProvider providedValuesWithExpectedType
     *
     * @param mixed $value
     * @param string $expectedType
     */
    public function itCanDetermineTypeOfValue($value, string $expectedType): void
    {
        $this->assertSame($expectedType, Values::typeOf($value));
    }

    public function provideNativeValuesWithStringRepresentation(): array
    {
        $obj = new stdClass();

        $anonObj = new class() {
        };

        $resource = $this->getResource();

        $closedResource = $this->getResource();
        fclose($closedResource);

        $closure = static function () {
        };

        return [
            'string' => ['foo', 'foo'],
            'int' => [1, '1'],
            'bool' => [true, 'true'],
            'null' => [null, 'null'],
            'float' => [0.1, '0.1'],
            'array-list' => [['foo', 'bar'], '[foo, bar]'],
            'array-map' => [[1 => 'foo', 3 => 'bar'], '{1=foo, 3=bar}'],
            'array-map-recursive' => [[1 => ['foo']], '{1=[...]}'],
            'object' => [$obj, sprintf('stdClass@%s', Values::hash($obj))],
            'anonymous-object' => [$anonObj, sprintf('anonymous@%s', Values::hash($anonObj))],
            'closure' => [
                $closure,
                sprintf('closure@%s', Values::hash($closure)),
            ],
            'resource' => [$resource, sprintf('resource(stream)@%s', Values::hash($resource))],
            'resource(closed)' => [$closedResource, sprintf('resource(closed)@%s', Values::hash($closedResource))],
        ];
    }

    /**
     * @test
     * @dataProvider provideNativeValuesWithStringRepresentation
     *
     * @param mixed $value
     * @param string $expectedString
     */
    public function itCanTransformNativeValueToString($value, string $expectedString): void
    {
        $this->assertEquals($expectedString, Values::toString($value));
    }

    /**
     * @test
     */
    public function itCanDetermineStringRepresentationOfHashable(): void
    {
        $expected = 'custom';

        $hashable = $this->createMock(Hashable::class);
        $hashable->expects($this->once())
            ->method('__toString')
            ->with()
            ->willReturn($expected);

        $this->assertEquals($expected, Values::toString($hashable));
    }

    protected function tearDown(): void
    {
        foreach ($this->resources as $resource) {
            fclose($resource);
        }
        parent::tearDown();
    }

    private function getResource()
    {
        return $this->resources[] = fopen('php://memory', 'rb');
    }

}
