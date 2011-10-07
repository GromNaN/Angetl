<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\XmlReader;

class XmlReaderTest extends ReaderTest
{
    public function testAddField()
    {
        $reader = $this->getReader();

        $fieldNames = array('title', 'language', 'price');

        $this->assertEquals($fieldNames, $reader->getFieldNames(), 'Get field names');
    }

    /**
     * @return \Angetl\Reader\XmlReader
     */
    protected function getReader()
    {
        $reader = new XmlReader(__DIR__.'/Fixtures/bookstore.xml');
        $reader
          ->setRecordXpath('//book')
          ->addField('title', 'string(./title/text())')
          ->addField('language', 'string(./title/@lang)')
          ->addField('price', 'string(./price/text())')
        ;

        return $reader;
    }
}
