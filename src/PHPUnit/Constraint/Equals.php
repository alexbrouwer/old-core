<?php

namespace PAR\Core\PHPUnit\Constraint;

use PAR\Core\ObjectInterface;
use PHPUnit\Framework\Constraint\Constraint;

class Equals extends Constraint
{
    /** @var ObjectInterface */
    private $object;

    public function __construct(ObjectInterface $object)
    {
        $this->object = $object;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return sprintf('equals %s', $this->object->toString());
    }

    /**
     * @inheritDoc
     */
    protected function matches($other): bool
    {
        return $this->object->equals($other);
    }

    /**
     * @inheritDoc
     */
    protected function failureDescription($other): string
    {
        if ($other instanceof ObjectInterface) {
            $otherExport = sprintf('%s', $other->toString());
        } else {
            $otherExport = $this->exporter()->export($other);
        }

        return sprintf('%s %s', $otherExport, $this->toString());
    }
}
