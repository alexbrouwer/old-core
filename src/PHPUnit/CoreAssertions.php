<?php

namespace PAR\Core\PHPUnit;

use PAR\Core\ObjectInterface;
use PAR\Core\PHPUnit\Constraint\Equals;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\LogicalNot;

trait CoreAssertions
{
    /**
     * Assert that the actual value not equals the expected ObjectInterface::equals implementation.
     *
     * @param ObjectInterface $expected
     * @param mixed           $actual
     * @param string          $message
     */
    public static function assertNotSameObject(ObjectInterface $expected, $actual, string $message = ''): void
    {
        Assert::assertThat(
            $actual,
            new LogicalNot(
                new Equals($expected)
            ),
            $message
        );
    }

    /**
     * Assert that the actual value equals the expected ObjectInterface::equals implementation.
     *
     * @param ObjectInterface $expected
     * @param mixed           $actual
     * @param string          $message
     */
    public static function assertSameObject(ObjectInterface $expected, $actual, string $message = ''): void
    {
        Assert::assertThat(
            $actual,
            new Equals($expected),
            $message
        );
    }
}
