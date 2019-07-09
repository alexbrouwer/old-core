<?php declare(strict_types=1);

namespace PARTest\Core\Fixtures;

use PAR\Core\ComparableInterface;
use PAR\Core\Exception\ClassCastException;
use PAR\Core\Exception\ClassMismatchException;
use PAR\Core\Helper\InstanceHelper;
use PAR\Core\ObjectInterface;

class Integer implements ComparableInterface, ObjectInterface
{
    /**
     * @var int
     */
    protected $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function fromNative(int $value): self
    {
        return new static($value);
    }

    /**
     * @inheritDoc
     */
    public function compareTo(ComparableInterface $other): int
    {
        if ($other instanceof self && get_class($other) === static::class) {
            return $this->value <=> $other->value;
        }

        throw ClassMismatchException::expectedInstance($this, $other);
    }

    /**
     * @inheritDoc
     */
    public function equals($other): bool
    {
        return InstanceHelper::isSameType($this, $other) && $this->value === $other->value;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return (string)$this->value;
    }

    public function toNative(): int
    {
        return $this->value;
    }
}
