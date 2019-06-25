<?php

namespace PAR\Core\Exception;

use Throwable;

final class ClassNotFoundException extends InvalidArgumentException
{
    /**
     * Returns exception explaining that class was not found.
     *
     * @param string         $class The FQCN that was not found.
     * @param Throwable|null $prev  Throwable that preceded this exception.
     *
     * @return ClassNotFoundException
     */
    public static function forClass(string $class, Throwable $prev = null): self
    {
        return new self(
            sprintf(
                'Class "%s" not found.',
                $class
            ),
            0,
            $prev
        );
    }
}
