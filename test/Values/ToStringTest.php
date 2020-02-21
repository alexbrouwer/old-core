<?php

declare(strict_types=1);

namespace PARTest\Core\Values;

use PAR\Core\Hashable;
use PAR\Core\Values;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ToStringTest extends TestCase
{
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

    public function provideNativeValuesWithStringRepresentation(): array
    {
        $obj = new stdClass();

        $anonObj = new class() {
        };

        $resource = fopen('php://memory', 'rb');

        $closedResource = fopen('php://memory', 'rb');
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
}