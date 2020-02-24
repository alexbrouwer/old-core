<?php

declare(strict_types=1);

namespace PAR\Core;

use Closure;
use PAR\Core\Exception\InvalidArgumentException;

final class ValueTester
{
    public const ARRAY = 'array';
    public const BOOL = 'bool';
    public const BOOLEAN = 'boolean';
    public const CALLABLE = 'callable';
    public const DOUBLE = 'double';
    public const FLOAT = 'float';
    public const INT = 'int';
    public const INTEGER = 'integer';
    public const ITERABLE = 'iterable';
    public const NUMERIC = 'numeric';
    public const MIXED = 'mixed';
    public const OBJECT = 'object';
    public const RESOURCE = 'resource';
    public const SCALAR = 'scalar';
    public const STRING = 'string';

    /**
     * @var array<string, callable>
     */
    private static array $typeTests = [
        self::ARRAY => 'is_array',
        self::BOOL => 'is_bool',
        self::BOOLEAN => 'is_bool',
        self::CALLABLE => 'is_callable',
        self::DOUBLE => 'is_float',
        self::FLOAT => 'is_float',
        self::INT => 'is_int',
        self::INTEGER => 'is_int',
        self::ITERABLE => 'is_iterable',
        self::NUMERIC => 'is_numeric',
        self::MIXED => [self::class, 'testMixed'],
        self::OBJECT => [self::class, 'testObject'],
        self::RESOURCE => [self::class, 'testResource'],
        self::SCALAR => 'is_scalar',
        self::STRING => 'is_string',
    ];

    /**
     * @var array<string, callable>
     */
    private static array $testers = [];

    /**
     * Returns a callable that can be used to test for the provided type.
     *
     * @param string $type The type to get a tester for
     *
     * @return callable
     */
    public static function forType(string $type): callable
    {
        $allowNull = false;
        $typeName = $type;
        if (preg_match('/^\?(.*)$/', $type, $match)) {
            $allowNull = true;
            $typeName = $match[1];
        }

        $typeTest = static::getTypeTester($typeName, $allowNull);

        if ($allowNull) {
            return static function ($value) use ($typeTest): bool {
                if (null === $value) {
                    return true;
                }

                return $typeTest($value);
            };
        }

        return $typeTest;
    }

    private static function getTypeTester(string $type, bool $allowNull): callable
    {
        $typeName = strtolower($type);
        $typeKey = ($allowNull ? '?' : '') . $typeName;

        if (!is_callable(self::$testers[$typeKey])) {
            $typeTest = self::createTypeTester($type, $allowNull);

            self::$testers[$typeKey] = $typeTest;
        }

        return self::$testers[$typeKey];
    }

    /**
     * @param mixed $value The value to test
     *
     * @return bool True if value is an object and not an instance of Closure
     */
    private static function testObject($value): bool
    {
        if ($value instanceof Closure) {
            return false;
        }

        return is_object($value);
    }

    /**
     * @param mixed $value The value to test
     *
     * @return bool True if value anything but NULL
     */
    private static function testMixed($value): bool
    {
        return null !== $value;
    }

    /**
     * @param mixed $value The value to test
     *
     * @return bool True if value is a (closed) resource
     */
    private static function testResource($value): bool
    {
        return in_array(gettype($value), ['resource', 'resource (closed)'], true);
    }

    private static function createTypeTester(string $type, bool $allowNull): callable
    {
        $typeName = strtolower($type);

        if (!array_key_exists($typeName, self::$typeTests) && !class_exists($type, true)) {
            throw new InvalidArgumentException(
                sprintf('Unknown value type "%s"', $type)
            );
        }

        if (!isset(self::$typeTests[$typeName])) {
            $typeTest = static function ($value) use ($type): bool {
                return is_object($value) && get_class($value) === $type;
            };
        } else {
            $typeTest = Closure::fromCallable(self::$typeTests[$typeName]);
        }

        if ($allowNull) {
            return static function ($value) use ($typeTest): bool {
                if (null === $value) {
                    return true;
                }

                return $typeTest($value);
            };
        }

        return $typeTest;
    }
}
