<?php

declare(strict_types=1);

namespace PAR\Core\Exception;

use PAR\Core\Values;

final class InvalidArgumentException extends \InvalidArgumentException implements Exception
{
    /**
     * @param string $expectedType
     * @param mixed $value
     *
     * @return self
     */
    public static function invalidTypeForValue(string $expectedType, $value): self
    {
        return new self(
            sprintf(
                'Value of type %s is not of expected type %s',
                Values::typeOf($value),
                $expectedType
            )
        );
    }
}
