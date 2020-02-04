<?php

declare(strict_types=1);

namespace PARTest\Core\Fixtures;

use PAR\Core\Hashable;
use PAR\Core\Traits;

class GenericHashable implements Hashable
{
    use Traits\GenericHashable;

    /**
     * @var int
     */
    private $hash;

    /**
     * @param int $hash
     */
    public function __construct(int $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @inheritDoc
     */
    public function hash(): int
    {
        return $this->hash;
    }
}