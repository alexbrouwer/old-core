<?php

declare(strict_types=1);

namespace PAR\Core;

use Ds\Vector as CompositeVector;

/**
 *
 */
final class Vector extends AbstractSequence
{
    private ?CompositeVector $composite;

    protected function composite(): CompositeVector
    {
        if (!$this->composite) {
            $this->composite = new CompositeVector();
        }

        return $this->composite;
    }
}
