<?php

namespace PAR\Core;

final class Comparator
{
    private function __construct()
    {
        // Make sure it cannot be instantiated
    }

    /**
     * @return Comparator
     */
    public static function callback(): self
    {
        return new self();
    }

    /**
     * @param ComparableInterface $a
     * @param ComparableInterface $b
     *
     * @return int
     */
    public function __invoke(ComparableInterface $a, ComparableInterface $b): int
    {
        return $a->compareTo($b);
    }
}
