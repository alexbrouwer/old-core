<?php

declare(strict_types=1);

namespace PAR\Core;

/**
 * This class implements the `Set` interface, backed by a hash map. It makes no guarantees as to the iteration order of the set; in particular, it does not guarantee that the order
 * will remain constant over time. This class permits the `null` element.
 *
 * @template E
 * @extends  AbstractSet<E>
 */
final class HashSet extends AbstractSet
{
    /**
     * Returns a hash set containing zero elements.
     *
     * @param string $type The allowed type for elements in this set
     *
     * @return self<E>
     */
    public static function empty(string $type): self
    {
        $typeTest = ValueTester::forType($type);

        /** @var iterable<E> $elements */
        $elements = [];

        return new self($type, $typeTest, $elements);
    }

    /**
     * Returns a hash set containing provided elements.
     *
     * @param string $type          The allowed type for elements in this set
     * @param iterable<E> $elements The elements to add to this set
     *
     * @return self<E>
     */
    public static function of(string $type, iterable $elements): self
    {
        $typeTest = ValueTester::forType($type);

        return new self($type, $typeTest, $elements);
    }
}
