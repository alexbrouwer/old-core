<?php declare(strict_types=1);

namespace PAR\Core\Helper;

use PAR\Core\ObjectInterface;

final class InstanceHelper extends HelperAbstract
{

    /**
     * Checks if instance is equal to any of those in the list.
     *
     * @param object|null        $instance  The instance to look for
     * @param array<object|null> $anyOfList The list to look in
     *
     * @return bool
     */
    public static function isAnyOf(?object $instance, array $anyOfList): bool
    {
        if (!is_object($instance) || empty($anyOfList)) {
            return false;
        }

        $matches = array_filter(
            $anyOfList,
            static function ($item) use ($instance) {
                if (!is_object($item)) {
                    return false;
                }

                if ($item === $instance) {
                    return true;
                }

                if ($item instanceof ObjectInterface) {
                    return $item->equals($instance);
                }

                return false;
            }
        );

        return count($matches) > 0;
    }

    /**
     * Returns true if actual data is of same class as expected.
     *
     * @param object $expected An instance of expected type
     * @param mixed  $actual   The data to test
     *
     * @return bool
     */
    public static function isSameType(object $expected, $actual): bool
    {
        return is_object($actual) && get_class($expected) === get_class($actual);
    }

    /**
     * Returns a string representation of provided object.
     *
     * @param object      $instance              The instance to cast to string.
     * @param string|null $representationalValue A text that represents the value of the instance
     *
     * @return string
     */
    public static function toString(object $instance, string $representationalValue = null): string
    {
        $class = get_class($instance);
        if (null === $representationalValue) {
            return sprintf('%s@%s', $class, spl_object_hash($instance));
        }

        return sprintf('%s("%s")', $class, $representationalValue);
    }
}
