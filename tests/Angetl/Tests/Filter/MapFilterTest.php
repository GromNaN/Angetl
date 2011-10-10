<?php

namespace Angetl\Tests\Filter;

use Angetl\Record;
use Angetl\Filter\MapFilter;

class MapFilterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataForFilterTest
     */
    public function testFilter($mapping, $expected, $message)
    {
        $values = array(
            'field1' => 'foo',
            'field2' => 'bar',
        );

        $record = new Record($values);

        $filter = new MapFilter($mapping);
        $filter->filter($record);

        $this->assertEquals($values + $expected, $record->getValues(), $message);
    }

    public function dataForFilterTest()
    {
        return array(
            array(
                array('out' => 'field1'),
                array('out' => 'foo'),
                'Mapping from simple field name'
            ),
            array(
                array('out' => function (Record $record) {
                    return $record['field2'];
                }),
                array('out' => 'bar'),
                'Mapping from lambda function'
            ),
        );
    }
}
