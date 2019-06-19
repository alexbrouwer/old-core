<?php declare(strict_types=1);

namespace PAR\Core\Helper;

use PAR\Core\Assert;

final class ArrayHelper extends HelperAbstract
{
    /**
     * Implode the provided list of string to the readable x, y or z form.
     *
     * @param string[] $list
     *
     * @return string
     */
    public static function readableImplode(array $list): string
    {
        Assert::allString($list);
        if (count($list) === 0) {
            return '';
        }

        $lastElement = array_pop($list);
        if (count($list) === 0) {
            return $lastElement;
        }

        return sprintf('%s or %s', implode(', ', $list), $lastElement);
    }
}
