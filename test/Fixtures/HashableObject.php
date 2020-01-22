<?php

declare(strict_types=1);

namespace PARTest\Core\Fixtures;

use PAR\Core\Hashable;
use PAR\Core\Traits;

class HashableObject implements Hashable
{
    use Traits\Equals;

    /**
     * @var string
     */
    private $hash;

    /**
     * @param string $hash
     */
    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @inheritDoc
     */
    public function hash(): string
    {
        return $this->hash;
    }

}