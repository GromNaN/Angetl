<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\PdoReader;

abstract class ReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testRead()
    {
        $reader = $this->getReader();

        $reader->open();

        foreach ($this->getExpectedRecords() as $i => $expect) {
            $record = $reader->read();
            $this->assertEquals($expect, $record, 'Record '.$i.' is read');
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
