<?php

namespace PAR\Core\Helper;

use PAR\Core\ObjectInterface;

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
        $type = gettype($data);

        if ($type === 'object') {
            $type = sprintf('instance of %s', get_class($data));

            if ($data instanceof ObjectInterface) {
                $type .= '@' . $data->toString();
            }
        }

        return $type;
    }
}
