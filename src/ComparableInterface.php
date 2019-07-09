<?php declare(strict_types=1);

namespace PAR\Core;

use PAR\Core\Exception\ClassMismatchException;

interface ComparableInterface
{
    /**
     * Compares this object with with other object. Returns a negative integer, zero or a positive integer as this
     * object is less than, equals to, or greater then the other object.
     *
     * @param ComparableInterface $other The other object to be compared.
     *
     * @return int
     * @throws ClassMismatchException If the other object's type prevents it from being compared to this object.
     */
    public function compareTo(ComparableInterface $other): int;
}
