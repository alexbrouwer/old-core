<?php

namespace PAR\Core;

trait ObjectCastToString
{
    /**
     * Returns a string representation of the object.
     *
     * @see ObjectInterface::toString()
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    abstract public function toString(): string;
}
