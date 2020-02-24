<?php

declare(strict_types=1);

namespace PARTest\Core\HashSet;

use ArrayIterator;
use PAR\Core\Exception\InvalidArgumentException;
use PAR\Core\HashSet;
use PARTest\Core\CollectionTestCase;
use PARTest\Core\Fixtures\GenericHashable;

final class AddTest extends CollectionTestCase
{
    /**
     * @test
     */
    public function itCanAddElement(): void
    {
        $set = HashSet::empty('string');

        $this->assertTrue($set->add('foo'));

        $this->assertCollectionContents(['foo'], $set);
    }

    /**
     * @test
     */
    public function itCanAddHashables(): void
    {
        $set = HashSet::empty(GenericHashable::class);

        $one = new GenericHashable(1);

        $this->assertTrue($set->add($one));

        $this->assertCollectionContents([$one], $set);

        // Same hash, should not add
        $this->assertFalse($set->add(new GenericHashable(1)));
    }

    /**
     * @test
     */
    public function itWillNotAddElementMoreThanOnce(): void
    {
        $set = HashSet::of('string', ['foo']);

        $this->assertFalse($set->add('foo'));

        $this->assertCollectionContents(['foo'], $set);
    }

    /**
     * @test
     */
    public function itCanAddNullElementIfAllowed(): void
    {
        $set = HashSet::empty('?string');

        $this->assertTrue($set->add(null));

        $this->assertCollectionContents([null], $set);
    }

    /**
     * @test
     */
    public function itCannotAddElementWithIncompatibleType(): void
    {
        $set = HashSet::empty('string');

        $this->expectException(InvalidArgumentException::class);

        $set->add(1);
    }

    /**
     * @test
     */
    public function itCanAddAllElementsFromArray(): void
    {
        $set = HashSet::empty('int');

        $this->assertTrue($set->addAll(range(1, 10)));

        $this->assertCollectionContents(range(1, 10), $set);

        $this->assertFalse($set->addAll(range(3, 8)));
    }

    /**
     * @test
     */
    public function itCanAddAllElementsFromNonArrayIterable(): void
    {
        $set = HashSet::empty('int');

        $set->addAll(new ArrayIterator(range(1, 10)));

        $this->assertCollectionContents(range(1, 10), $set);
    }

    /**
     * @test
     */
    public function itCannotAddElementWithIncompatibleTypeFromList(): void
    {
        $set = HashSet::empty('int');

        $this->expectException(InvalidArgumentException::class);

        $set->addAll([1, 'foo', 2]);
    }

}
