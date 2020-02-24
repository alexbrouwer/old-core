<?php

declare(strict_types=1);

namespace PAR\Core;

abstract class AbstractSequence extends AbstractCollection implements Sequence
{
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        // TODO: Implement toArray() method.
        return [];
    }

    /**
     * @inheritDoc
     */
    public function hash()
    {
        // TODO: Implement hash() method.
        return null;
    }
}
