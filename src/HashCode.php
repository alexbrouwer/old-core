<?php

declare(strict_types=1);

namespace PAR\Core;

use TypeError;

/**
 * Collection of static methods to easily transform a value of any type to an 32 bit integer representation.
 */
final class HashCode
{

    public const MAX_RECURSION_DEPTH = 10;

    /**
     * Transform any value to a hash, recursion safe.
     *
     * @param mixed $value  The value to transform to a hash
     * @param int $maxDepth The maximum recursion level
     *
     * @return int The resulting hash
     */
    public static function forAny($value, int $maxDepth = self::MAX_RECURSION_DEPTH): int
    {
        $type = gettype($value);
        switch ($type) {
            case 'boolean':
                return self::forBool($value);
            case 'integer':
                return static::forInt($value);
            case 'double':
            case 'float':
                return self::forFloat($value);
            case 'string':
                return static::forString($value);
            case 'array':
                return static::forArray($value, $maxDepth);
            case 'object':
                return self::forObject($value);
            case 'resource':
            case 'resource (closed)':
                return static::forResource($value);
            case 'NULL':
                return 0;
            case 'unknown type':
                // "unknown type" is an official return value from `gettype`
            default:
                // This case exists because we use a switch and just in case a new type is introduced that is not (yet) supported here.
                throw new TypeError(sprintf('Unknown type "%s"', $type));
        }
    }

    /**
     * Transform an array to a hash.
     *
     * @param array<mixed> $values The array to transform
     * @param int $maxDepth        The maximum recursion depth. Defaults to `static::MAX_RECURSION_DEPTH`
     *
     * @return int The resulting hash
     */
    public static function forArray(array $values, int $maxDepth = self::MAX_RECURSION_DEPTH): int
    {
        if ($maxDepth === 0 || empty($values)) {
            return 0;
        }

        $hashes = [];
        foreach ($values as $value) {
            $hashes[] = static::forAny($value, $maxDepth - 1);
        }

        if (array_values($values) !== $values) {
            $hashes[] = static::forArray(array_keys($values), 1);
        }

        return array_reduce(
            $hashes,
            static function (int $previous, int $hash): int {
                return static::handleOverflow($previous + $hash);
            },
            0
        );
    }

    /**
     * Transform a boolean to integer hash.
     *
     * @param bool $value The boolean to transform
     *
     * @return int The resulting hash
     */
    public static function forBool(bool $value): int
    {
        return $value ? 1231 : 1237;
    }

    /**
     * Transform a float to integer hash.
     *
     * @param float $value The float to transform
     *
     * @return int The resulting hash
     */
    public static function forFloat(float $value): int
    {
        $packed = pack('g', $value);
        [, $number] = unpack('V', $packed);

        return static::handleOverflow($number);
    }

    /**
     * Transform an integer to integer hash.
     *
     * @param int $value The integer to transform
     *
     * @return int The resulting hash
     */
    public static function forInt(int $value): int
    {
        $max = 2 ** 31 - 1;
        $min = (2 ** 31) * -1;
        if ($value <= $max && $value >= $min) {
            return $value;
        }

        $hash = ($value ^ ($value >> 32));

        return static::handleOverflow($hash);
    }

    /**
     * Transform an object to integer hash.
     *
     * @param object $value The object to transform
     *
     * @return int The resulting hash
     */
    public static function forObject(object $value): int
    {
        if ($value instanceof Hashable) {
            return static::forAny($value->hash());
        }

        return static::forInt(spl_object_id($value));
    }

    /**
     * Transform an resource to integer hash.
     *
     * @param resource $value The resource to transform
     *
     * @return int The resulting hash
     */
    public static function forResource($value): int
    {
        return static::forInt((int)$value);
    }

    /**
     * Transform a string to a hash.
     *
     * @param string $value The string to transform
     *
     * @return int The resulting hash
     */
    public static function forString(string $value): int
    {
        $hash = 0;
        $length = strlen($value);
        for ($i = 0; $i < $length; $i++) {
            $hash = static::handleOverflow(31 * $hash + ord($value[$i]));
        }

        return $hash;
    }

    /**
     * Handles overflowing of an integer
     *
     * @param int $value
     *
     * @return int
     */
    private static function handleOverflow(int $value): int
    {
        $bits = 32;
        $sign_mask = 1 << $bits - 1;
        $clamp_mask = ($sign_mask << 1) - 1;

        if ($value & $sign_mask) {
            return ((~$value & $clamp_mask) + 1) * -1;
        }

        return $value & $clamp_mask;
    }
}
