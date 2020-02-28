<?php

declare(strict_types=1);

namespace PAR\Core;

use IteratorAggregate;
use PAR\Core\Exception\InvalidArgumentException;

/**
 * @template E
 */
interface Set extends Collection, IteratorAggregate
{
    /**
     * Adds the specified element to this set if it is not already present.
     *
     * @param E $element The element to be added to this set
     *
     * @return bool `true` if this set did not already contains the specified element
     * @throws InvalidArgumentException If the type of the specified element prevents it from being added to this set
     */
    public function add($element): bool;

    /**
     * Adds all of the elements in the specified list to this set.
     *
     * @param iterable<E> $elements The list of elements to be added to this collection
     *
     * @return bool `true` if this set changed as a result of the call
     * @throws InvalidArgumentException If the type of an element in the specified list prevents it from being added to this set
     */
    public function addAll(iterable $elements): bool;

    /**
     * Returns `true` if this set contains the specified element.
     *
     * @param E $element The element whose presence in this set is to be tested
     *
     * @return bool `true` if this set contains the specified element
     * @throws InvalidArgumentException If the type of the specified element is incompatible with this set
     */
    public function contains($element): bool;

    /**
     * Returns `true` if this set contains all of the elements in the specified list.
     *
     * @param iterable<E> $elements The list of elements whose presence in this set is to be tested
     *
     * @return bool `true` if this set contains the all of the elements in the specified list
     * @throws InvalidArgumentException If the type of one or more elements in the specified list are incompatible with this set
     */
    public function containsAll(iterable $elements): bool;

    /**
     * Removes the specified element from this set if it is present.
     *
     * @param E $element The element to remove from this set, if present
     *
     * @return bool `true` if this set contained the specified element
     * @throws InvalidArgumentException If the type of the specified element is incompatible with this set
     */
    public function remove($element): bool;

    /**
     * Removes all of this set's elements that are also contained in the specified list.
     *
     * @param iterable<E> $elements The list of elements to be removed from this set
     *
     * @return bool `true` if this collection changed as a result of the call
     * @throws InvalidArgumentException If the type of one or more elements in the specified list are incompatible with this set
     */
    public function removeAll(iterable $elements): bool;

    /**
     * @inheritDocs
     *
     * @return iterable<E>
     */
    public function getIterator(): iterable;
}
