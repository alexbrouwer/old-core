<?php declare(strict_types=1);

namespace PAR\Core\Helper;

use PAR\Core\Exception\ClassCastException;
use PAR\Core\ObjectInterface;

final class InstanceHelper extends HelperAbstract
{
    /**
     * Asserts if provided instance is of expected class. Throws ClassCastException if not.
     *
     * @param mixed  $instance      The instance to assert
     * @param string $expectedClass The expected FQCN
     *
     * @throws ClassCastException
     */
    public static function assertIsOfClass($instance, string $expectedClass): void
    {
        if (!static::isOfClass($instance, $expectedClass)) {
            throw ClassCastException::unexpectedType($instance, $expectedClass);
        }
    }

    /**
     * Determines if instance is an object of expected class.
     *
     * @param mixed  $instance      The instance to test
     * @param string $expectedClass The expected FQCN
     *
     * @return bool
     */
    public static function isOfClass($instance, string $expectedClass): bool
    {
        if (!is_object($instance)) {
            return false;
        }

        return get_class($instance) === $expectedClass;
    }

    /**
     * Returns a string consisting of the name of the class of the instance, the at-sign character "@", and the SPL
     * object hash of the object.
     *
     * In other words, this method returns a string in the format:
     * `Fully\Qualified\ClassName . '@' . spl_object_hash`
     *
     * @param object $instance The instance to transform
     *
     * @return string
     */
    public static function toString(object $instance): string
    {
        return sprintf('%s@%s', get_class($instance), static::hashCode($instance));
    }

    /**
     * Returns a hash code value for the object
     *
     * @param object $instance The instance to transform
     *
     * @return string
     */
    public static function hashCode(object $instance): string
    {
        return spl_object_hash($instance);
    }

    /**
     * Checks if instance is equals to any of those in the list
     *
     * @param mixed $instance  The instance to look for
     * @param array $anyOfList The list to look in
     *
     * @return bool
     */
    public static function isAnyOf($instance, array $anyOfList): bool
    {
        if (!is_object($instance)) {
            return false;
        }

        $matches = array_filter(
            $anyOfList,
            static function ($anyInstance) use ($instance) {
                if (!is_object($anyInstance)) {
                    return false;
                }

                if ($instance instanceof ObjectInterface) {
                    return $instance->equals($anyInstance);
                }

                return $instance === $anyInstance;
            }
        );

        return count($matches) > 0;
    }
}
