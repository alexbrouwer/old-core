<?php

declare(strict_types=1);

namespace PAR\Core;

/**
 * // not nullable
 * EnumMap::of(Enumerable::class,'bool', []);
 *
 * // nullable value
 * EnumMap::of(Enumerable::class, '?bool', []);
 */
final class EnumMap extends AbstractMap
{

}
