<?php

namespace Angetl\Tests;

use Angetl\Processor;
use Angetl\Reader\MemoryReader;
use Angetl\Filter\MapFilter;
use Angetl\Writer\NullWriter;

class ProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testIterator()
    {
        $values = array(
            array('foo' => 1),
            array('foo' => 2),
            array('foo' => 3),
            array('foo' => 4),
        );

        $processor = new Processor();
        $processor
            ->setReader(new MemoryReader($values))
            ->setFilter(new MapFilter(array('bar' => 'foo')))
            ->setWriter(new NullWriter())
        ;

        foreach ($processor as $key => $record) {
            $this->assertEquals($record->getValues(), array('foo' => $key, 'bar' => $key));
        }
    }
}
