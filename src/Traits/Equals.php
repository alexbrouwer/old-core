<?php

declare(strict_types=1);

namespace PAR\Core\Traits;

use PAR\Core\Hashable;

/**
 * Common to structures that implement the \Par\Core\Hashable interface. This will add an implementation for the `equals` method.
 */
trait Equals
{
    public function equals($other): bool
    {
        if ($this instanceof Hashable) {
            return $other instanceof Hashable && $this->hash() === $other->hash();
        }

        return $this === $other;
    }
}
