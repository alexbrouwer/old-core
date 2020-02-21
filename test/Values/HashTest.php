<?php

declare(strict_types=1);

namespace PARTest\Core\Values;

use PAR\Core\Hashable;
use PAR\Core\HashCode;
use PAR\Core\Values;
use PHPUnit\Framework\TestCase;
use stdClass;

final class HashTest extends TestCase
{
    /**
     * @test
     */
    public function itReturnsHashOfHashable(): void
    {
        $expectedHash = microtime(true);

        $hashable = $this->createMock(Hashable::class);
        $hashable->expects($this->once())
            ->method('hash')
            ->with()
            ->willReturn($expectedHash);

        $this->assertEquals($expectedHash, Values::hash($hashable));
    }

    public function provideScalarAndNullValue(): array
    {
        return [
            'null' => [null],
            'float' => [0.1],
            'int' => [-1],
            'string' => ['Hello World!'],
            'bool' => [false],
        ];
    }

    /**
     * @test
     * @dataProvider provideScalarAndNullValue
     *
     * @param bool|float|int|string|null $scalarOrNullValue
     */
    public function itReturnsValueForScalarAndNullValue($scalarOrNullValue): void
    {
        $this->assertEquals($scalarOrNullValue, Values::hash($scalarOrNullValue));
    }

    public function provideNonScalarOrNullValueAndHash(): array
    {
        $obj = new stdClass();

        $resource = fopen('php://memory', 'rb');

        $closedResource = fopen('php://memory', 'rb');
        fclose($closedResource);

        return [
            'object' => [$obj, HashCode::forObject($obj)],
            'resource' => [$resource, HashCode::forResource($resource)],
            'resource(closed)' => [$closedResource, HashCode::forResource($closedResource)],
            'array-list' => [[1, 4], 5],
            'array-map' => [[1 => 'foo', 4 => 'bar'], 198878],
            'array-max-recursion' => [[1, [1, [1, [1, [1, [1, [1, [1, [1, [1, [1, [1, []]]]]]]]]]]]], 10],
        ];
    }

    /**
     * @test
     * @dataProvider provideNonScalarOrNullValueAndHash
     *
     * @param object|resource|callable|iterable|array $nonScalarValue
     * @param int $expectedHashCode
     */
    public function itReturnsHashCodeForNonScalarOrNullValue($nonScalarValue, int $expectedHashCode): void
    {
        $this->assertEquals($expectedHashCode, Values::hash($nonScalarValue));
    }

}
