<?php

namespace Angetl\Tests\Transformer;

use Angetl\Record;
use Angetl\Transformer\MapTransformer;

class MapTransformerTest extends \PHPUnit_Framework_TestCase
{

    public function testTransform()
    {
        $mapping = array(
            'out1' => 'in1',
            'out2' => function (Record $record) {
                return $record['in2'];
            }
        );
        $transformer = new MapTransformer($mapping);

        $recordList = array(
            Record::createFromValues(array('in1' => 'val1', 'in2' => 'val2'))
        );

        $transformer->transform($recordList);

        $expected = array(
            'in1' => 'val1',
            'in2' => 'val2',
            'out1' => 'val1',
            'out2' => 'val2',
        );
        $record = $recordList[0];
        $this->assertEquals($expected, $record->getValues());
    }

}
