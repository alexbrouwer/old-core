<?php

namespace PARTest\Core\Fixtures;

use PAR\Core\Assert;

class Natural extends Integer
{
    protected function __construct(int $value)
    {
        Assert::natural($value);

        parent::__construct($value);
    }
}
