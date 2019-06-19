<?php declare(strict_types=1);

namespace PAR\Core\Exception;

use RuntimeException;

final class ClassCastException extends RuntimeException implements ExceptionInterface
{
    /**
     * @param string $type
     * @param string $expectedType
     *
     * @return ClassCastException
     */
    public static function unsupportedType(string $type, string $expectedType): self
    {
        return new self(
            sprintf(
                'Type %s is unsupported, expected %s',
                $type,
                $expectedType
            )
        );
    }
}
