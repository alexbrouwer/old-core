<?php

declare(strict_types=1);

namespace PAR\Core;

/**
 * Hashable is an interface which allows objects to be used as keys.
 *
 * It's an more OOP alternative to spl_object_hash(), which determines an object's hash based on its handle: this means
 * Interface to make object implementations, specifically those in a domain, more predictable.
 *
 * Enforces equality testing via `$instance->equals( $anyValue );` and always getting a boolean answer.
 * Also casting to string via `$instance->toString();` giving the callee a textual representation of the
 * instance. Especially useful when passing to a unit for storage, usage in error messages or in debugging setups.
 */
interface Hashable
{
    /**
     * Determines if two objects should be considered equal. Both objects will
     * be instances of the same class but may not be the same instance.
     *
     * A common implementation would be:
     * ```
     * return $other instanceof self && $this->hash() === $other->hash();
     * ```
     *
     * @param mixed $other An instance of the same class to compare to.
     *
     * @return bool
     */
    public function equals($other): bool;

    /**
     * Produces a string to be used as the object's hash, which determines
     * where it goes in the hash table. While this value does not have to be
     * unique, objects which are equal must have the same hash value.
     *
     * @return string
     */
    public function hash(): string;
}
