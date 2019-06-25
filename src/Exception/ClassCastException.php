<?php declare(strict_types=1);

namespace PAR\Core\Exception;

use PAR\Core\Helper\StringHelper;

final class ClassCastException extends RuntimeException
{
    /**
     * @param mixed  $data
     * @param string $expectedClass
     *
     * @return ClassCastException
     */
    public static function unexpectedType($data, string $expectedClass): self
    {
        return new self(
            sprintf(
                'Expected an instance of %s, got %s',
                $expectedClass,
                StringHelper::typeOf($data)
            )
        );
    }
}
