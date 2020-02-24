<?php

declare(strict_types=1);

namespace PARTest\Core\HashSet;

use ArrayIterator;
use PAR\Core\Exception\InvalidArgumentException;
use PAR\Core\HashSet;
use PARTest\Core\CollectionTestCase;

final class RemoveTest extends CollectionTestCase
{
    /**
     * @test
     */
    public function itCanRemoveElement(): void
    {
        $set = HashSet::of('string', ['foo']);

        $this->assertTrue($set->remove('foo'));

        $this->assertCollectionContents([], $set);

        // Already removed
        $this->assertFalse($set->remove('foo'));
    }

    /**
     * @test
     */
    public function itCanRemoveNullElementIfAllowed(): void
    {
        $set = HashSet::of('?string', [null]);

        $this->assertTrue($set->remove(null));

        $this->assertCollectionContents([], $set);
    }

    /**
     * @test
     */
    public function itCannotRemoveElementWithIncompatibleType(): void
    {
        $set = HashSet::empty('string');

        $this->expectException(InvalidArgumentException::class);

        $set->remove(1);
    }

    /**
     * @test
     */
    public function itCanRemoveAllElementsFromArray(): void
    {
        $set = HashSet::of('int', range(1, 10));

        $this->assertTrue($set->removeAll(range(2, 9)));

        $this->assertCollectionContents([1, 10], $set);

        // Already removed
        $this->assertFalse($set->removeAll(range(2, 9)));
    }

    /**
     * @test
     */
    public function itCanAddAllElementsFromNonArrayIterable(): void
    {
        $set = HashSet::of('int', range(1, 10));

        $this->assertTrue($set->removeAll(new ArrayIterator(range(2, 9))));

        $this->assertCollectionContents([1, 10], $set);
    }

    /**
     * @test
     */
    public function itCannotRemoveElementWithIncompatibleTypeFromList(): void
    {
        $set = HashSet::of('int', [1, 2]);

        $this->expectException(InvalidArgumentException::class);

        $set->removeAll([1, 'foo', 2]);
    }

}
