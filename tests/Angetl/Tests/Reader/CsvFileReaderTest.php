<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\CsvFileReader;

class CsvFileReaderTest extends ReaderTest
{
    protected $class = 'CsvFileReader';

    public function dataForTestRead()
    {
        $reader1 = new CsvFileReader(__DIR__.'/Fixtures/bookstore1.csv');

        $reader2 = new CsvFileReader(__DIR__.'/Fixtures/bookstore2.csv', array(
            'delimiter' => ':',
            'names_first' => false,
            'skip' => 4,
        ));
        $reader2->addField('title', 2);
        $reader2->addField('language', 0);
        $reader2->addField('price', 3);

        return array(
            array($reader1),
            array($reader2),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructWithInvalidFilename()
    {
        new CsvFileReader(__DIR__.'/invalid');
    }
}
