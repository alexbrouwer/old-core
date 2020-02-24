<?php

declare(strict_types=1);

namespace PAR\Core;

use Countable;
use JsonSerializable;
use OutOfBoundsException;
use Traversable;

/**
 *
 */
interface Collection extends Traversable, Countable, Hashable, JsonSerializable
{
    /**
     * Removes all values from the collection.
     */
    public function clear(): void;

    /**
     * Returns the size of the collection.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Returns whether the collection is empty.
     *
     * This should be equivalent to a count of zero, but is not required.
     * Implementations should define what empty means in their own context.
     *
     * @return bool `true` if the collection is empty
     */
    public function isEmpty(): bool;

    /**
     * Transform this collection to a native array
     *
     * @return array<mixed,mixed>
     * @throws OutOfBoundsException If the collection cannot be transformed to a native array because on of its key types is not supported
     */
    public function toArray(): array;
}
