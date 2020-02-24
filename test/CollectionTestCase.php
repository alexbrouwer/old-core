<?php

declare(strict_types=1);

namespace PARTest\Core;

use PAR\Core\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTestCase extends TestCase
{
    protected function assertCollectionContents(array $expectedContents, Collection $collection): void
    {
        $actualContents = [];
        foreach ($collection as $key => $value) {
            $actualContents[$key] = $value;
        }

        $this->assertSame(array_values($expectedContents), array_values($actualContents), 'Collection values are not the same');
        $this->assertSame(array_keys($expectedContents), array_keys($actualContents), 'Collection keys are not the same');
    }

}
