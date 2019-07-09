<?php

namespace PAR\Core\Helper;

use PAR\Core\Exception\ClassNotFoundException;
use ReflectionClass;
use ReflectionException;

final class ClassHelper extends HelperAbstract
{
    /**
     * @var array<string, ReflectionClass>
     */
    private static $reflectionClasses = [];

    /**
     * Returns a ReflectionClass object.
     *
     * This will cache the reflected class to prevent the performance hit of reflection as much as possible.
     *
     * @param string $class The class to reflect.
     *
     * @return ReflectionClass
     * @throws ClassNotFoundException When class could not be found.
     */
    public static function getReflectionClass(string $class): ReflectionClass
    {
        if (!isset(self::$reflectionClasses[$class])) {
            try {
                self::$reflectionClasses[$class] = new ReflectionClass($class);
            } catch (ReflectionException $e) {
                throw ClassNotFoundException::forClass($class, $e);
            }
        }

        return self::$reflectionClasses[$class];
    }

    /**
     * Returns true if provided class is declared as abstract.
     *
     * @param string $class Class to test.
     *
     * @return bool
     * @throws ClassNotFoundException When class could not be found.
     */
    public static function isAbstract(string $class): bool
    {
        $reflectionClass = self::getReflectionClass($class);

        return $reflectionClass->isAbstract();
    }

    /**
     * Returns true if provided class is declared as final.
     *
     * @param string $class Class to test.
     *
     * @return bool
     * @throws ClassNotFoundException When class could not be found.
     */
    public static function isFinal(string $class): bool
    {
        $reflectionClass = self::getReflectionClass($class);

        return $reflectionClass->isFinal();
    }
}
