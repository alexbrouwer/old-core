<?php

declare(strict_types=1);

namespace PARTest\Core\HashSet;

use ArrayIterator;
use PAR\Core\Exception\InvalidArgumentException;
use PAR\Core\HashSet;
use PARTest\Core\CollectionTestCase;

final class ContainsTest extends CollectionTestCase
{
    /**
     * @test
     */
    public function itCanDeterminePresenceOfElement(): void
    {
        $set = HashSet::of('string', ['foo', 'bar']);

        $this->assertTrue($set->contains('foo'));
        $this->assertFalse($set->contains('baz'));
    }

    /**
     * @test
     */
    public function itCanDeterminePresenceOfNull(): void
    {
        $set = HashSet::of('?string', ['foo', null]);

        $this->assertTrue($set->contains(null));
    }

    /**
     * @test
     */
    public function itCannotDeterminePresenceOfElementWithIncompatibleType(): void
    {
        $set = HashSet::empty('string');

        $this->expectException(InvalidArgumentException::class);

        $set->contains(1);
    }

    /**
     * @test
     */
    public function itCanDeterminePresenceOfAllElementsInArray(): void
    {
        $set = HashSet::of('string', ['foo', 'bar', 'baz']);

        $this->assertTrue($set->containsAll(['foo', 'baz']));
        $this->assertFalse($set->containsAll(['foo', 'bar', 'foobar']));
    }

    /**
     * @test
     */
    public function itCanDeterminePresenceOfAllElementsNonArrayIterable(): void
    {
        $set = HashSet::of('string', ['foo', 'bar', 'baz']);

        $this->assertTrue($set->containsAll(new ArrayIterator(['foo', 'baz'])));
        $this->assertFalse($set->containsAll(new ArrayIterator(['foo', 'bar', 'foobar'])));
    }

    /**
     * @test
     */
    public function itCannotDeterminePresenceOfElementWithIncompatibleTypeFromList(): void
    {
        $set = HashSet::empty('int');

        $this->expectException(InvalidArgumentException::class);

        $set->containsAll([1, 'foo', 2]);
    }
}
