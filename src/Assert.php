<?php declare(strict_types=1);

namespace PAR\Core;

use PAR\Core\Exception\ClassCastException;
use PAR\Core\Exception\InvalidArgumentException;
use PAR\Core\Helper\InstanceHelper;
use Webmozart\Assert\Assert as BaseAssert;

class Assert extends BaseAssert
{
    public static function sameType($otherInstance, object $asInstance): void
    {
        if (!InstanceHelper::isOfSameClassAs($asInstance, $otherInstance)) {
            throw ClassCastException::unsupportedType(static::typeToString($otherInstance), get_class($asInstance));
        }
    }

    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgumentException($message);
    }
}
