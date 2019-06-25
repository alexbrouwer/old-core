<?php

namespace PAR\Core\Helper;

use PAR\Core\Exception\ClassNotFoundException;
use ReflectionClass;
use ReflectionException;

final class ClassHelper extends HelperAbstract
{
    private static $reflectionClassCache = [];

    /**
     * Returns true if provided class is declared as abstract
     *
     * @param string $class Fully Qualified Class Name
     *
     * @return bool
     */
    public static function isAbstract(string $class): bool
    {
        $reflectionClass = self::getReflectionClass($class);
        return $reflectionClass->isAbstract();
    }

    /**
     * @param string $class
     *
     * @return ReflectionClass
     */
    public static function getReflectionClass(string $class): ReflectionClass
    {
        if (!isset(self::$reflectionClassCache[$class])) {
            try {
                self::$reflectionClassCache[$class] = new ReflectionClass($class);
            } catch (ReflectionException $e) {
                throw ClassNotFoundException::forClass($class, $e);
            }
        }

        return self::$reflectionClassCache[$class];
    }
}
