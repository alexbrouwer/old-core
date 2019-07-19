<?php declare(strict_types=1);

namespace PARTest\Core\Helper;

use PAR\Core\ComparableInterface;
use PAR\Core\Helper\FormattingHelper;
use PAR\Core\ObjectCastToString;
use PAR\Core\ObjectInterface;
use PARTest\Core\Fixtures\Integer;
use PHPUnit\Framework\TestCase;

class FormattingHelperTest extends TestCase
{
    public function provideTypeOfArguments(): array
    {
        return [
            ['text', 'string'],
            [123, 'integer'],
            [[], 'array'],
            [[1, 2], 'array<integer>'],
            [[1, ''], 'array<integer|string>'],
            [['a' => 1, 'b' => 2], 'array<string,integer>'],
            [
                [
                    [
                        'text',
                        [
                            [],
                        ],
                    ],
                ],
                'array<array<array|string>>'],
            [$this, get_class($this)],
            [
                new class() extends TestCase
                {
                },
                'anonymous::PHPUnit\Framework\TestCase',
            ],
            [
                new class() implements ObjectInterface, ComparableInterface
                {
                    use ObjectCastToString;

                    public function compareTo(ComparableInterface $other): int
                    {
                        // stub
                    }

                    public function equals($other): bool
                    {
                        // stub
                    }

                    public function toString(): string
                    {
                        // stub
                    }

                },
                'anonymous[PAR\Core\ObjectInterface,PAR\Core\ComparableInterface]',
            ],
        ];
    }

    public function provideValueOfArguments(): array
    {
        $anonymousExtended = new class() extends TestCase
        {
        };

        $anonymousImplementing = new class() implements ComparableInterface
        {
            public function compareTo(ComparableInterface $other): int
            {
                // stub
            }
        };

        return [
            ['text', "'text'"],
            [123, '123'],
            [false, 'false'],
            [true, 'true'],
            [null, 'null'],
            [[], 'array(0)'],
            [[1, 2], 'array<integer>(2)'],
            [[1, ''], 'array<integer|string>(2)'],
            [['a' => 1, 'b' => 2], 'array<string,integer>(2)'],
            [$this, get_class($this) . '@' . spl_object_hash($this)],
            [Integer::fromNative(3), 'PARTest\Core\Fixtures\Integer("3")'],
            [$anonymousExtended, 'anonymous::PHPUnit\Framework\TestCase@' . spl_object_hash($anonymousExtended)],
            [$anonymousImplementing, 'anonymous[PAR\Core\ComparableInterface]@' . spl_object_hash($anonymousImplementing)],
        ];
    }

    /**
     * @dataProvider provideTypeOfArguments
     *
     * @param mixed  $data
     * @param string $expected
     */
    public function testTypeOf($data, string $expected): void
    {
        $this->assertSame($expected, FormattingHelper::typeOf($data));
    }

    /**
     * @dataProvider provideValueOfArguments
     *
     * @param mixed  $data
     * @param string $expected
     */
    public function testValueOf($data, string $expected): void
    {
        $this->assertSame($expected, FormattingHelper::valueOf($data));
    }
}
