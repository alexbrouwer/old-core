<?php

namespace PAR\Core\Tests\Fixtures;

use PAR\Core\Assert;

class Natural extends Integer
{
    protected function __construct(int $value)
    {
        Assert::natural($value);

        parent::__construct($value);
    }
}
