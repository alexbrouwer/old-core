<?php

namespace PAR\Core\PHPUnit;

use PAR\Core\ObjectInterface;
use PAR\Core\PHPUnit\Constraint\ValueEquality;
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
     *
     * @deprecated use self::assertNotValueEquality
     */
    public static function assertNotSameObject(ObjectInterface $expected, $actual, string $message = ''): void
    {
        self::assertNotValueEquality($expected, $actual, $message);
    }

    /**
     * Assert that the actual value not equals the expected ObjectInterface::equals implementation.
     *
     * @param ObjectInterface $expected
     * @param mixed           $actual
     * @param string          $message
     */
    public static function assertNotValueEquality(ObjectInterface $expected, $actual, string $message = ''): void
    {
        Assert::assertThat(
            $actual,
            new LogicalNot(
                new ValueEquality($expected)
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
     *
     * @deprecated use self::assertValueEquality
     */
    public static function assertSameObject(ObjectInterface $expected, $actual, string $message = ''): void
    {
        self::assertValueEquality($expected, $actual, $message);
    }

    /**
     * Assert that the actual value equals the expected ObjectInterface::equals implementation.
     *
     * @param ObjectInterface $expected
     * @param mixed           $actual
     * @param string          $message
     */
    public static function assertValueEquality(ObjectInterface $expected, $actual, string $message = ''): void
    {
        Assert::assertThat(
            $actual,
            new ValueEquality($expected),
            $message
        );
    }
}
