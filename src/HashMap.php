<?php

declare(strict_types=1);

namespace PAR\Core;

/**
 * // not nullable
 * HashMap::of('string','bool', []);
 *
 * // nullable key and value
 * HashMap::of('?string', '?bool', []);
 */
final class HashMap extends AbstractMap
{

}
