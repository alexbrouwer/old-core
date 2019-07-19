<?php

namespace PAR\Core;

interface ObjectInterface
{
    /**
     * Returns a string representation of the object.
     *
     * Should always implement:
     * ```
     * return $this->toString();
     * ```
     *
     * @see ObjectInterface::toString()
     * @see ObjectCastToString
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Determines if this object equals provided value.
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
