<?php

declare(strict_types=1);

namespace PARTest\Core;

use ArrayIterator;
use PAR\Core\Exception\InvalidArgumentException;
use PAR\Core\ValueTester;
use PARTest\Core\Fixtures\GenericHashable;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ValueTesterTest extends TestCase
{
    private array $resources = [];

    /**
     * @test
     */
    public function itThrowsAnExceptionForUnknownType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ValueTester::forType('not-a-type-or-class');
    }

    public function provideTypeTests(): array
    {
        $callable = static function () {
            return null;
        };

        $resource = $this->getResource();

        $closedResource = $this->getResource();
        fclose($closedResource);

        $values = [
            'array' => ['foo', 'bar'],
            'bool' => true,
            'callable' => $callable,
            'float' => 0.1,
            'int' => 1,
            'iterable' => new ArrayIterator(),
            'object' => new stdClass(),
            'resource' => $resource,
            'closed-resource' => $closedResource,
            'string' => 'text',
            GenericHashable::class => new GenericHashable(1),
        ];

        $types = [
            'array' => ['array'],
            'bool' => ['bool'],
            'boolean' => ['bool'],
            'callable' => ['callable'],
            'double' => ['float'],
            'float' => ['float'],
            'int' => ['int'],
            'integer' => ['int'],
            'iterable' => ['iterable', 'array'],
            'numeric' => ['int', 'float'],
            'mixed' => array_keys($values),
            'object' => ['object', 'iterable', GenericHashable::class],
            'resource' => ['resource', 'closed-resource'],
            'scalar' => ['string', 'bool', 'float', 'int'],
            'string' => ['string'],
            GenericHashable::class => [GenericHashable::class],
        ];

        $tests = [];

        foreach ($types as $type => $validTypes) {
            foreach ($values as $valueType => $value) {
                $testName = sprintf('%s-with-%s', $type, $valueType);

                $tests[$testName] = [in_array($valueType, $validTypes, true), $type, $value];
            }

            $tests[$type . '-with-null'] = [false, $type, null];
            $tests[$type . '-nullable'] = [true, '?' . $type, null];
        }

        return $tests;
    }

    /**
     * @test
     * @dataProvider provideTypeTests
     *
     * @param bool $expectedResult
     * @param string $type
     * @param mixed $valueToTest
     */
    public function itCanTestIfValueIsOfType(bool $expectedResult, string $type, $valueToTest): void
    {
        $test = ValueTester::forType($type);

        $this->assertIsCallable($test);
        $this->assertEquals($expectedResult, $test($valueToTest));
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
