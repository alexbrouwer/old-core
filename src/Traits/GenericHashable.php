<?php

declare(strict_types=1);

namespace PAR\Core\Traits;

use PAR\Core\Hashable;

/**
 * Common to structures that implement the \Par\Core\Hashable interface. This will add an common implementation for the `equals` method.
 */
trait GenericHashable
{
    public function equals($other): bool
    {
        if ($this instanceof Hashable && $other instanceof self) {
            return get_class($other) === get_class($this) && $this->hash() === $other->hash();
        }

        return $this === $other;
    }

    public function __toString(): string
    {
        return sprintf('%s@%s', get_class($this), dechex($this->hash()));
    }
}
