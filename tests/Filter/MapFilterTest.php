<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Filter;

use Angetl\Filter\MapFilter;
use Angetl\Record;
use PHPUnit\Framework\TestCase;

class MapFilterTest extends TestCase
{
    /**
     * @dataProvider dataForFilterTest
     */
    public function testFilter($mapping, $expected, $message)
    {
        $values = [
            'field1' => 'foo',
            'field2' => 'bar',
        ];

        $record = new Record($values);

        $filter = new MapFilter($mapping);
        $filter->filter($record);

        $this->assertEquals($values + $expected, $record->getValues(), $message);
    }

    public function dataForFilterTest()
    {
        return [
            [
                ['out' => 'field1'],
                ['out' => 'foo'],
                'Mapping from simple field name',
            ],
            [
                ['out' => function (Record $record) {
                    return $record['field2'];
                }],
                ['out' => 'bar'],
                'Mapping from lambda function',
            ],
        ];
    }
}
