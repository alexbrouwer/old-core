<?php

declare(strict_types=1);

namespace PAR\Core\Exception;

use Throwable;

/**
 * Base interface for all exceptions thrown in this package.
 *
 * This allows a structure like:
 *
 * ```php
 * try {
 *      // Something that throws an exception
 * } catch (\PAR\Core\Exception\Exception $e) {
 *      // Handle in specific way
 * }
 * ```
 */
interface Exception extends Throwable
{

}
