<?php

declare(strict_types=1);

namespace PAR\Core;

use Ds\Collection as CompositeCollection;
use IteratorAggregate;
use IteratorIterator;
use PAR\Core\Traits;

abstract class AbstractCollection implements IteratorAggregate, Collection
{
    use Traits\GenericHashable;

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        $this->composite()->clear();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->composite());
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return count($this) === 0;
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        return new IteratorIterator($this->composite());
    }

    /**
     * Returns the composite used within this collection
     *
     * @return CompositeCollection
     */
    abstract protected function composite(): CompositeCollection;
}
