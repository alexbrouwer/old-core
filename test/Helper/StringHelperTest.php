<?php declare(strict_types=1);

namespace PARTest\Core\Helper;

use PAR\Core\Helper\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    /**
     * @dataProvider provideTypeOfArguments
     *
     * @param mixed  $data
     * @param string $expectedString
     */
    public function testTypeOfReturnsExpectedString($data, string $expectedString): void
    {
        $this->assertSame($expectedString, StringHelper::typeOf($data));
    }

    public function provideTypeOfArguments(): array
    {
        return [
            ['text', 'string'],
            [123, 'integer'],
            [[], 'array'],
            [$this, 'instance of ' . get_class($this)],
        ];
    }
}
