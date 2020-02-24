<?php

declare(strict_types=1);

namespace PAR\Core;

use Ds\Stack as CompositeStack;

/**
 *
 */
final class Stack extends AbstractCollection
{
    private ?CompositeStack $composite;

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

    protected function composite(): CompositeStack
    {
        if (!$this->composite) {
            $this->composite = new CompositeStack();
        }

        return $this->composite;
    }
}
