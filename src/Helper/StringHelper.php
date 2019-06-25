<?php

namespace PAR\Core\Helper;

final class StringHelper extends HelperAbstract
{
    /**
     * Determines the type of data. Combines gettype and get_class.
     *
     * @param mixed $data
     *
     * @return string
     */
    public static function typeOf($data): string
    {
        if (is_object($data)) {
            return 'instance of ' . get_class($data);
        }

        return gettype($data);
    }
}