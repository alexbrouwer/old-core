<?php

declare(strict_types=1);

namespace PARTest\Core\Fixtures;

use PAR\Core\Hashable;
use PAR\Core\Traits;

class GenericHashable implements Hashable
{
    use Traits\GenericHashable;

    /**
     * @var int|string|bool|null|float
     */
    private $hash;

    /**
     * @param int|string|bool|null|float $hash
     */
    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @inheritDoc
     */
    public function hash()
    {
        return $this->hash;
    }
}