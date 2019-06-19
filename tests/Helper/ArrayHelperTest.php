<?php

namespace PAR\Core\Tests\Helper;

use PAR\Core\Helper\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    public function provideForReadableImplode(): array
    {
        return [
            'empty'               => [[], ''],
            'one item'            => [['item1'], 'item1'],
            'two items'           => [['item1', 'item2'], 'item1 or item2'],
            'more than two items' => [['item1', 'item2', 'item3', 'item4'], 'item1, item2, item3 or item4'],
        ];
    }

    /**
     * @dataProvider provideForReadableImplode
     *
     * @param array  $list
     * @param string $expected
     */
    public function testReadableImplode(array $list, string $expected): void
    {
        $this->assertSame(ArrayHelper::readableImplode($list), $expected);
    }
}
