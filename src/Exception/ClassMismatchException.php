<?php declare(strict_types=1);

namespace PAR\Core\Exception;

use PAR\Core\Helper\FormattingHelper;

final class ClassMismatchException extends RuntimeException
{
    /**
     * @param object $expected An instance of the expected type.
     * @param mixed  $actual   The actual received data.
     *
     * @return self
     */
    public static function expectedInstance(object $expected, $actual): self
    {
        return self::expectedType(get_class($expected), $actual);
    }

    /**
     * @param string $expectedType The expected type.
     * @param mixed  $actual       The actual received data.
     *
     * @return self
     */
    public static function expectedType(string $expectedType, $actual): self
    {
        return new self(
            sprintf(
                'Expected an object of type %s, got %s',
                $expectedType,
                FormattingHelper::typeOf($actual)
            )
        );
    }

    /**
     * @param string     $expectedType The expected type.
     * @param string|int $arrayKey     The key of the array that is invalid.
     * @param mixed      $arrayValue   The value at said key.
     *
     * @return ClassMismatchException
     */
    public static function expectedTypeInArray(string $expectedType, $arrayKey, $arrayValue): self
    {
        return new self(
            sprintf(
                'Expected an object of type %s in array at key %s, got %s',
                $expectedType,
                $arrayKey,
                FormattingHelper::typeOf($arrayValue)
            )
        );
    }
}
