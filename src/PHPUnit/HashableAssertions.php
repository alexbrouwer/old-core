<?php

declare(strict_types=1);

namespace PAR\Core\PHPUnit;

use PAR\Core\Hashable;
use PAR\Core\PHPUnit\Constraint\HashableEquals;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\LogicalNot;

trait HashableAssertions
{
    public function assertValueNotEquals(Hashable $expected, $actual, string $message = ''): void
    {
        Assert::assertThat(
            $actual,
            new LogicalNot(
                new HashableEquals($expected)
            ),
            $message
        );
    }

    public function assertValueEquals(Hashable $expected, $actual, string $message = ''): void
    {
        Assert::assertThat(
            $actual,
            new HashableEquals($expected),
            $message
        );
    }
}
