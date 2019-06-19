<?php declare(strict_types=1);

namespace PAR\Core\Tests\Fixtures;

use PAR\Core\Assert;
use PAR\Core\ComparableInterface;
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
        Assert::sameType($other, $this);

        /* @var self $other */
        return $this->value <=> $other->value;
    }

    /**
     * @inheritDoc
     */
    public function equals($other): bool
    {
        return InstanceHelper::isOfSameClassAs($this, $other) && $this->value === $other->value;
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
