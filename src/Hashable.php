<?php

declare(strict_types=1);

namespace PAR\Core;

use PAR\Core\Traits;

/**
 * Hashable is an interface which allows objects to be used as keys.
 *
 * It's an alternative to spl_object_hash(), which determines an object's hash based on its handle: this means
 * that two objects that are considered equal by an implicit definition would not be treated as equal because they are
 * not the same instance.
 */
interface Hashable extends \Ds\Hashable
{
    /**
     * Determines if two objects should be considered equal. Both objects will
     * be instances of the same class but may not be the same instance.
     *
     * @param mixed $other The referenced value with which to compare
     *
     * @return bool True if this object is the same as the other argument
     *
     * @see Traits\GenericHashable for an implementation
     */
    public function equals($other): bool;

    /**
     * Produces a integer to be used as the object's hash, which determines
     * where it goes in the hash table. While this value does not have to be
     * unique, objects which are equal must have the same hash value.
     *
     * @return int
     */
    public function hash(): int;

    /**
     * Returns a string representation of the object. In general, the `toString` method returns a string that
     * "textually represents" this object. The result should be a concise but informative representation that
     * is easy for a person to read.
     *
     * @return string
     *
     * @see Traits\GenericHashable for an implementation
     */
    public function __toString(): string;
}
