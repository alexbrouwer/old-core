<?php

declare(strict_types=1);

namespace PAR\Core;

use PAR\Core\Exception\InvalidArgumentException;

/**
 * A specialized Set implementation for use with enum types. All of the elements in an enum set must come from a single enum type that is specified when the set is created.
 */
final class EnumSet extends AbstractSet
{
    /**
     * Returns an enum set containing zero elements.
     *
     * @param string $type The allowed enum type for elements in this set
     *
     * @return self<Enumerable>
     */
    public static function empty(string $type): self
    {
        return new self($type, []);
    }

    /**
     * Returns an enum set containing provided elements.
     *
     * @param string $type                   The allowed enum type for elements in this set
     * @param iterable<Enumerable> $elements The elements to add to this set
     *
     * @return self<Enumerable>
     */
    public static function of(string $type, iterable $elements): self
    {
        return new self($type, $elements);
    }

    /**
     * @param string $type                   The enum type for elements in this set,
     * @param iterable<Enumerable> $elements The elements to add to this set
     */
    protected function __construct(string $type, iterable $elements)
    {
        if (!class_exists($type, true)) {
            throw new InvalidArgumentException(sprintf('Enum "%s" not found', $type));
        }

        if (in_array(Enumerable::class, class_implements($type), true)) {
            throw new InvalidArgumentException(sprintf('Enum "%s" must be an implementation of the "%s" interface', $type, Enumerable::class));
        }

        $typeTest = static function ($value) use ($type): bool {
            return is_object($value) && get_class($value) === $type;
        };

        parent::__construct($type, $typeTest, $elements);
    }
}
