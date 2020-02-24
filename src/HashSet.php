<?php

declare(strict_types=1);

namespace PAR\Core;

/**
 * This class implements the `Set` interface, backed by a hash map. It makes no guarantees as to the iteration order of the set; in particular, it does not guarantee that the order
 * will remain constant over time. This class permits the `null` element.
 */
final class HashSet extends AbstractSet
{
    /**
     * Returns a hash set containing zero elements.
     *
     * @param string $type The allowed type for elements in this set
     *
     * @return self<mixed>
     */
    public static function empty(string $type): self
    {
        $typeTest = ValueTester::forType($type);

        return new self($type, $typeTest, []);
    }

    /**
     * Returns a hash set containing provided elements.
     *
     * @param string $type              The allowed type for elements in this set
     * @param iterable<mixed> $elements The elements to add to this set
     *
     * @return self<mixed>
     */
    public static function of(string $type, iterable $elements): self
    {
        $typeTest = ValueTester::forType($type);

        return new self($type, $typeTest, $elements);
    }
}
