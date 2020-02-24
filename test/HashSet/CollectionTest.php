<?php

declare(strict_types=1);

namespace PARTest\Core\HashSet;

use PAR\Core\HashSet;
use PARTest\Core\CollectionTestCase;

final class CollectionTest extends CollectionTestCase
{
    /**
     * @test
     */
    public function itIsCountable(): void
    {
        $set = HashSet::of('string', ['foo', 'bar']);

        $this->assertCount(2, $set);
    }

    /**
     * @test
     */
    public function itCanBeCleared(): void
    {
        $set = HashSet::of('string', ['foo', 'bar']);

        $this->assertCollectionContents(['foo', 'bar'], $set);

        $set->clear();

        $this->assertCollectionContents([], $set);
    }

    /**
     * @test
     */
    public function itIsEmptyWithoutElements(): void
    {
        $set = HashSet::empty('string');

        $this->assertTrue($set->isEmpty());

        $set->add('foo');

        $this->assertFalse($set->isEmpty());
    }

    /**
     * @test
     */
    public function itCanBeCastToString(): void
    {
        $set = HashSet::of('int', range(1, 10));

        $this->assertSame('[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]', (string)$set);
    }

}
