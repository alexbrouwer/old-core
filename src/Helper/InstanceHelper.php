<?php declare(strict_types=1);

namespace PAR\Core\Helper;

final class InstanceHelper extends HelperAbstract
{

    /**
     * Determines if all other instances are objects of the same class as instance
     *
     * @param object $instance          The instance to use as source
     * @param mixed  $otherInstance     The other instance to test
     * @param mixed  ...$otherInstances The other instances to test
     *
     * @return bool
     */
    public static function isOfSameClassAs(object $instance, $otherInstance,
        ...$otherInstances
    ): bool {
        $className = get_class($instance);

        array_unshift($otherInstances, $otherInstance);

        foreach ($otherInstances as $additionalOtherInstance) {
            if (!static::isOfClass($className, $additionalOtherInstance)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determines if instance is an object of class $className
     *
     * @param string $className The class name to determine
     * @param mixed  $instance  The instance to test
     *
     * @return bool
     */
    public static function isOfClass(string $className, $instance): bool
    {
        if (!is_object($instance)) {
            return false;
        }

        return get_class($instance) === $className;
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
}
