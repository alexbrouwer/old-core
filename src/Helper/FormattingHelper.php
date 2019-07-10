<?php

namespace PAR\Core\Helper;

use PAR\Core\ObjectInterface;

final class FormattingHelper extends HelperAbstract
{
    /**
     * Determines the type of data. Combines gettype and get_class.
     *
     * @param mixed $data
     * @param int   $depth To prevent massive deep nested array after 3 levels we stop
     *
     * @return string
     */
    public static function typeOf($data, int $depth = 0): string
    {
        if ($data === null) {
            return 'null';
        }

        if (is_array($data)) {
            if (empty($data) || $depth >= 2) {
                return 'array';
            }

            $types = [];

            if (array_values($data) !== $data) {
                // determine type of key
                $types[] = self::determineArrayTypes(array_keys($data), $depth);
            }

            $types[] = self::determineArrayTypes($data, $depth);

            return sprintf('array<%s>', implode(',', $types));
        }

        if (is_object($data)) {
            $class = get_class($data);
            if (preg_match('/^class@anonymous/', $class)) {
                $reflectionClass = ClassHelper::getReflectionClass($class);
                $parent = $reflectionClass->getParentClass();
                if ($parent) {
                    $parent = '::' . $parent->getName();
                } elseif (count($reflectionClass->getInterfaceNames())) {
                    $parent = '[' . implode(',', $reflectionClass->getInterfaceNames()) . ']';
                }
                $class = sprintf('anonymous%s', $parent);
            }

            return $class;
        }

        return gettype($data);
    }

    private static function determineArrayTypes(array $values, int $depth = 0): string
    {
        $valuesTypes = array_unique(
            array_map(
                static function ($value) use ($depth) {
                    return self::typeOf($value, ++$depth);
                }, $values
            )
        );

        sort($valuesTypes);

        return implode('|', $valuesTypes);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function valueOf($value): string
    {
        if ($value === null) {
            return 'null';
        }

        if ($value === true) {
            return 'true';
        }

        if ($value === false) {
            return 'false';
        }

        if (is_float($value) && (float)((int)$value) === $value) {
            return "$value.0";
        }

        if (is_resource($value)) {
            return sprintf(
                'resource(%d) of type (%s)',
                $value,
                get_resource_type($value)
            );
        }

        if (is_string($value)) {
            // Match for most non printable chars somewhat taking multibyte chars into account
            if (preg_match('/[^\x09-\x0d\x1b\x20-\xff]/', $value)) {
                return 'Binary String: 0x' . bin2hex($value);
            }

            return "'" .
                str_replace(
                    '<lf>', "\n",
                    str_replace(
                        ["\r\n", "\n\r", "\r", "\n"],
                        ['\r\n<lf>', '\n\r<lf>', '\r<lf>', '\n<lf>'],
                        $value
                    )
                ) .
                "'";
        }

        if (is_array($value)) {
            return self::typeOf($value) . '(' . count($value) . ')';
        }

        if (is_object($value)) {
            $class = self::typeOf($value);

            if ($value instanceof ObjectInterface) {
                return sprintf('%s("%s")', $class, $value->toString());
            }

            return sprintf('%s@%s', $class, InstanceHelper::toString($value));
        }

        return var_export($value, true);
    }
}
