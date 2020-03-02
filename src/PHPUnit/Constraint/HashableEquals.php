<?php

declare(strict_types=1);

namespace PAR\Core\PHPUnit\Constraint;

use PAR\Core\Hashable;
use PHPUnit\Framework\Constraint\Constraint;
use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

final class HashableEquals extends Constraint
{
    private Hashable $object;

    public function __construct(Hashable $object)
    {
        $this->object = $object;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return sprintf('equals %s', (string)$this->object);
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
        if ($other instanceof Hashable) {
            $otherExport = (string)$other;
        } else {
            $otherExport = $this->exporter()->export($other);
        }

        return sprintf('%s %s', $otherExport, $this->toString());
    }

    /**
     * @inheritDoc
     */
    protected function additionalFailureDescription($other): string
    {
        if ($other instanceof Hashable) {
            $to = (string)$other;
        } else {
            $to = $this->exporter()->export($other);
        }

        $outputBuilder = new UnifiedDiffOutputBuilder("--- Expected\n+++ Actual\n");

        return (new Differ($outputBuilder))->diff((string)$this->object, $to);
    }
}
