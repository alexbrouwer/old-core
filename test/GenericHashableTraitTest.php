<?php

declare(strict_types=1);

namespace PARTest\Core;

use PARTest\Core\Fixtures\GenericHashable;
use PHPUnit\Framework\TestCase;
use stdClass;

class GenericHashableTraitTest extends TestCase
{
    /**
     * @test
     */
    public function itIsEqualToSelf(): void
    {
        $instance = new GenericHashable('hash');

        $this->assertTrue($instance->equals($instance));
    }

    /**
     * @test
     */
    public function itIsEqualToInstanceWithSameHash(): void
    {
        $instance = new GenericHashable('hash');
        $other = new GenericHashable('hash');

        $this->assertNotSame($other, $instance);
        $this->assertTrue($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceWithDifferentHash(): void
    {
        $instance = new GenericHashable('hash');
        $other = new GenericHashable('other-hash');

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfDifferentType(): void
    {
        $instance = new GenericHashable('hash');
        $other = new stdClass();

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToDifferentValueType(): void
    {
        $instance = new GenericHashable(null);
        $other = null;

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itIsNotEqualToInstanceOfChildWithSameHash(): void
    {
        $hash = 'foo';
        $instance = new GenericHashable($hash);
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
        $other = new GenericHashable($hash);

        $this->assertFalse($instance->equals($other));
    }

    /**
     * @test
     */
    public function itCanBeTransformedToString(): void
    {
        $hash = 'hash';
        $instance = new GenericHashable($hash);

        $this->assertSame(
            sprintf('%s@%s', get_class($instance), $hash),
            (string)$instance
        );
    }

}
