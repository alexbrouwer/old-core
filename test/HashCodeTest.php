<?php

declare(strict_types=1);

namespace PARTest\Core;

use PAR\Core\HashCode;
use PARTest\Core\Fixtures\GenericHashable;
use PARTest\Core\Traits\ResourceTrait;
use PHPUnit\Framework\TestCase;
use stdClass;

final class HashCodeTest extends TestCase
{
    use ResourceTrait;

    /**
     * @return array<string, array>
     */
    public function provideForStringValue(): array
    {
        return [
            'string' => ['Hello World!', -969099747],
        ];
    }

    /**
     * @return array<string, array>
     */
    public function provideForFloatValue(): array
    {
        return [
            'double-positive' => [1.1, 1066192077],
            'double-negative' => [-0.333, -1096122630],
            'float' => [1.0365E+36, 2068291429],
        ];
    }

    /**
     * @return array<string, array>
     */
    public function provideForResourceValue(): array
    {
        $resource = $this->createResource();
        $closedResource = $this->createClosedResource();

        return [
            'resource' => [$resource, (int)$resource],
            'resource-closed' => [$closedResource, (int)$closedResource],
        ];
    }

    /**
     * @return array<string, array>
     */
    public function provideForObjectValue(): array
    {
        $obj = new stdClass();

        return [
            'object' => [$obj, spl_object_id($obj)],
            'hashable-int' => [new GenericHashable(2), 2],
            'hashable-string' => [new GenericHashable('foo'), 101574],
        ];
    }

    /**
     * @return array<string, array>
     */
    public function provideForIntValue(): array
    {
        return [
            'int-positive' => [1, 1],
            'int-negative' => [-12, -12],
            'int-max' => [PHP_INT_MAX, -2147483648],
            'int-min' => [PHP_INT_MIN, -2147483648],
        ];
    }

    /**
     * @return array<string, array>
     */
    public function provideForArrayValue(): array
    {
        return [
            'array-list' => [[1, 4], 5],
            'array-map' => [[1 => 'foo', 4 => 'bar'], 198878],
            'array-max-recursion' => [[1, [1, [1, [1, [1, [1, [1, [1, [1, [1, [1, [1, []]]]]]]]]]]]], 10],
        ];
    }

    /**
     * @return array<string, array>
     */
    public function provideForBooleanValue(): array
    {
        return [
            'bool(true)' => [true, 1231],
            'bool(false)' => [false, 1237],
        ];
    }

    /**
     * @return array<string, array>
     */
    public function provideForAnyValue(): array
    {
        return array_merge(
            $this->provideForBooleanValue(),
            $this->provideForFloatValue(),
            $this->provideForIntValue(),
            $this->provideForResourceValue(),
            $this->provideForObjectValue(),
            $this->provideForStringValue(),
            $this->provideForArrayValue(),
            [
                'null' => [null, 0],
            ]
        );
    }

    /**
     * @test
     * @dataProvider provideForStringValue
     *
     * @param string $value
     * @param int $expectedHash
     */
    public function itCanCreateHashForStringValue(string $value, int $expectedHash): void
    {
        $this->assertEquals($expectedHash, HashCode::forString($value));
    }

    /**
     * @test
     * @dataProvider provideForBooleanValue
     *
     * @param bool $value
     * @param int $expectedHash
     */
    public function itCanCreateHashForBooleanValue(bool $value, int $expectedHash): void
    {
        $this->assertEquals($expectedHash, HashCode::forBool($value));
    }

    /**
     * @test
     * @dataProvider provideForFloatValue
     *
     * @param float $value
     * @param int $expectedHash
     */
    public function itCanCreateHashForFloatValue(float $value, int $expectedHash): void
    {
        $this->assertEquals($expectedHash, HashCode::forFloat($value));
    }

    /**
     * @test
     * @dataProvider provideForResourceValue
     *
     * @param resource $value
     * @param int $expectedHash
     */
    public function itCanCreateHashForResourceValue($value, int $expectedHash): void
    {
        $this->assertEquals($expectedHash, HashCode::forResource($value));
    }

    /**
     * @test
     * @dataProvider provideForObjectValue
     *
     * @param object $value
     * @param int $expectedHash
     */
    public function itCanCreateHashForObjectValue(object $value, int $expectedHash): void
    {
        $this->assertEquals($expectedHash, HashCode::forObject($value));
    }

    /**
     * @test
     * @dataProvider provideForIntValue
     *
     * @param int $value
     * @param int $expectedHash
     */
    public function itCanCreateHashForIntValue(int $value, int $expectedHash): void
    {
        $this->assertEquals($expectedHash, HashCode::forInt($value));
    }

    /**
     * @test
     * @dataProvider provideForAnyValue
     *
     * @param mixed $value
     * @param int $expectedHash
     */
    public function itCanCreateHashForAnyValue($value, int $expectedHash): void
    {
        $this->assertEquals($expectedHash, HashCode::forAny($value));
    }
}
