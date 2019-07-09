<?php declare(strict_types=1);

namespace PARTest\Core\Helper;

use PAR\Core\Helper\FormattingHelper;
use PHPUnit\Framework\TestCase;

class FormattingHelperTest extends TestCase
{
    /**
     * @dataProvider provideTypeOfArguments
     *
     * @param mixed  $data
     * @param string $expectedString
     */
    public function testTypeOfReturnsExpectedString($data, string $expectedString): void
    {
        $this->assertSame($expectedString, FormattingHelper::typeOf($data));
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
