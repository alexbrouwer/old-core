<?php

declare(strict_types=1);

namespace PARTest\Core\HashSet;

use PAR\Core\HashSet;
use PARTest\Core\CollectionTestCase;

final class CreateTest extends CollectionTestCase
{
    /**
     * @test
     */
    public function itCanCreateAnEmptySet(): void
    {
        $set = HashSet::empty('string');

        $this->assertCollectionContents([], $set);
    }

    /**
     * @test
     */
    public function itCanCreateFromArray(): void
    {
        $elements = ['foo', 'bar'];
        $set = HashSet::of('string', $elements);

        $this->assertCollectionContents($elements, $set);
    }
}
