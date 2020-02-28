<?php

declare(strict_types=1);

namespace PAR\Core;

use Closure;
use Ds\Set as CompositeSet;
use PAR\Core\Exception\InvalidArgumentException;

/**
 * @template   E
 * @implements Set<E>
 */
abstract class AbstractSet extends AbstractCollection implements Set
{
    /**
     * @var string
     */
    protected string $elementType;

    private ?Closure $typeTest = null;

    /**
     * @var CompositeSet<E>|null
     */
    private ?CompositeSet $composite = null;

    /**
     * @inheritDoc
     */
    public function add($element): bool
    {
        $this->assertElementType($element);

        if ($this->contains($element)) {
            return false;
        }

        $this->composite()->add($element);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function addAll(iterable $elements): bool
    {
        $changed = false;
        foreach ($elements as $element) {
            if ($this->add($element)) {
                $changed = true;
            }
        }

        return $changed;
    }

    /**
     * @inheritDoc
     */
    public function contains($element): bool
    {
        $this->assertElementType($element);

        return $this->composite()->contains($element);
    }

    /**
     * @inheritDoc
     */
    public function containsAll(iterable $elements): bool
    {
        $this->assertElementTypes($elements);

        return $this->composite()->contains(...$elements);
    }

    /**
     * @inheritDoc
     */
    public function remove($element): bool
    {
        $this->assertElementType($element);

        $sizeBefore = count($this);
        $this->composite()->remove($element);

        return $sizeBefore !== count($this);
    }

    /**
     * @inheritDoc
     */
    public function removeAll(iterable $elements): bool
    {
        $this->assertElementTypes($elements);

        $sizeBefore = count($this);
        $this->composite()->remove(...$elements);

        return $sizeBefore !== count($this);
    }

    /**
     * @inheritDoc
     */
    public function hash()
    {
        $hashes = array_map(
            [HashCode::class, 'forAny'],
            $this->composite()->toArray()
        );

        return HashCode::forArray($hashes, 1);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $strings = array_map(
            [Values::class, 'toString'],
            $this->composite()->toArray()
        );

        return sprintf('[%s]', implode(', ', $strings));
    }

    /**
     * @inheritDoc
     *
     * @return array<E>
     */
    public function toArray(): array
    {
        return $this->composite()->toArray();
    }

    /**
     * @inheritDoc
     * @return CompositeSet<E>
     */
    protected function composite(): CompositeSet
    {
        if (!$this->composite) {
            $this->composite = new CompositeSet();
        }

        return $this->composite;
    }

    /**
     * Asserts if elements are of expected type
     *
     * @param iterable<E> $elements The elements of which to assert the type
     *
     * @throws InvalidArgumentException If one or more of the elements does not match the expected elementType
     */
    protected function assertElementTypes(iterable $elements): void
    {
        foreach ($elements as $element) {
            $this->assertElementType($element);
        }
    }

    /**
     * Asserts if element is of expected type
     *
     * @param E $element The element of which to assert the type
     *
     * @throws InvalidArgumentException If element does not match the expected elementType
     */
    protected function assertElementType($element): void
    {
        $isValidType = $this->typeTest;
        if (!$isValidType($element)) {
            throw InvalidArgumentException::invalidTypeForValue($this->elementType, $element);
        }
    }

    /**
     * @param string $type          The type of element to include in this set,
     * @param callable $typeTest    A callable that is able to test if element is of the correct type
     * @param iterable<E> $elements The elements to add to this set
     */
    protected function __construct(string $type, callable $typeTest, iterable $elements)
    {
        $this->elementType = $type;
        $this->typeTest = $typeTest instanceof Closure ? $typeTest : Closure::fromCallable($typeTest);

        $this->addAll($elements);
    }
}
