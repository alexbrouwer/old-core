<?php

namespace PAR\Core;

/**
 * Interface to make object implementations, specifically those in a domain, more predictable.
 *
 * Enforces equality testing via `$instance->equals( $anyValue );` and always getting a boolean answer.
 * Also casting to string via `$instance->toString();` giving the callee a textual representation of the
 * instance. Especially useful when passing to a unit for storage, usage in error messages or in debugging setups.
 */
interface ObjectInterface
{

    /**
     * Determines if this object equals the provided other value.
     *
     * A common implementation would be:
     * ```
     * if ( $other instanceof self && get_class($other) === static::class) {
     *      return $this->value === $other->value;
     * }
     *
     * return false;
     * ```
     *
     * @param mixed $other The other value to compare with.
     *
     * @return bool
     */
    public function equals($other): bool;

    /**
     * Returns a string representation of the object. In general, the `toString` method returns a string that
     * "textually represents" this object. The result should be a concise but informative representation that
     * is easy for a person to read.
     *
     * A simple implementation would be:
     * ```
     * return spl_object_hash($this);
     * ```
     *
     * @return string
     */
    public function toString(): string;
}
