<?php

namespace PAR\Core;

interface ObjectInterface
{
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
     * return \Par\Core\Helper\InstanceHelper::toString($this, $this->value);
     * ```
     *
     * @return string
     */
    public function toString(): string;
}
