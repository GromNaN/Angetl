<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\Reader as ReaderInterface;

abstract class ReaderTest extends \PHPUnit_Framework_TestCase
{
    protected $class = '';

    /**
     * @dataProvider dataForTestRead
     */
    public function testRead($reader)
    {
        foreach ($this->getExpectedRecords() as $i => $expect) {
            $record = $reader->read();
            $this->assertInstanceOf('Angetl\Record', $record, $this->class.'::read() returns a Record object');
            $this->assertEquals($expect, $record->getValues(), $this->class.'::read() Record '.$i.' is read');
        }

        $this->assertFalse($reader->read(), 'End of file');
    }

    abstract public function dataForTestRead();

    /**
     * @return array
     */
    protected function getExpectedRecords()
    {
        return array(
            0 => array(
                'title' => 'Harry Potter',
                'language' => 'eng',
                'price' => '29.99',
            ),
            1 => array(
                'title' => 'Leçons de XML',
                'language' => 'fra',
                'price' => '39.95',
            ),
        );
    }
}
