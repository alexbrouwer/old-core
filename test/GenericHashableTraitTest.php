<?php

declare(strict_types=1);

namespace PARTest\Core;

use PARTest\Core\Fixtures\GenericHashable;
use PHPUnit\Framework\TestCase;
use stdClass;

class GenericHashableTraitTest extends TestCase
{
    public function getInstance($hash): GenericHashable
    {
        return new GenericHashable($hash);
    }

    /**
     * @test
     */
    public function itIsEqualToSelf(): void
    {
        $instance = $this->getInstance('hash');

        $this->assertTrue($instance->equals($instance));
    }

    /**
     * @test
     */
    public function itIsEqualToInstanceWithSameHash(): void
    {
        $instance = $this->getInstance('hash');
        $other = $this->getInstance('hash');

        $this->assertNotSame($other, $instance);
        $this->assertTrue($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceWithDifferentHash(): void
    {
        $instance = $this->getInstance('hash');
        $other = $this->getInstance('other-hash');

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfDifferentType(): void
    {
        $instance = $this->getInstance('hash');
        $other = new stdClass();

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToDifferentValueType(): void
    {
        $instance = $this->getInstance(null);
        $other = null;

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfChildWithSameHash(): void
    {
        $hash = 'foo';
        $instance = $this->getInstance($hash);
        $other = new class($hash) extends GenericHashable {
        };

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfParentWithSameHash(): void
    {
        $hash = 'hash';
        $instance = new class($hash) extends GenericHashable {
        };
        $other = $this->getInstance($hash);

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itCanBeTransformedToString(): void
    {
        $hash = 'hash';
        $instance = $this->getInstance($hash);

        $this->assertSame(
            sprintf('%s@%s', get_class($instance), $hash),
            (string)$instance
        );
    }

}
