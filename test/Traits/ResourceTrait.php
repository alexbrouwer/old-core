<?php

declare(strict_types=1);

namespace PARTest\Core\Traits;

use RuntimeException;

trait ResourceTrait
{
    /**
     * @return resource
     */
    protected function createResource()
    {
        $resource = fopen('php://memory', 'rb');
        if (is_resource($resource)) {
            return $resource;
        }

        throw new RuntimeException('Cannot create resource "php://memory"');
    }

    /**
     * @return resource
     */
    protected function createClosedResource()
    {
        $resource = $this->createResource();

        fclose($resource);

        return $resource;
    }
}