<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\PdoReader;

abstract class ReaderTest extends \PHPUnit_Framework_TestCase
{
    protected $class = '';

    public function testRead()
    {
        $reader = $this->getReader();

        $reader->open();

        foreach ($this->getExpectedRecords() as $i => $expect) {
            $record = $reader->read();
            $this->assertInstanceOf('Angetl\Record', $record, $this->class.'::read() returns a Record object');
            $this->assertEquals($expect, $record->getValues(), $this->class.'::read() Record '.$i.' is read');
        }

        $this->assertNull($reader->read(), 'End of file');

        $reader->close();
    }

    /**
     * @return \Angetl\Reader\AbstractReader
     */
    abstract protected function getReader();

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
