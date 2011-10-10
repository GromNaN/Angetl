<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\XmlReader;

class XmlReaderTest extends ReaderTest
{
    protected $class = 'XmlReader';

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
        $doc = new \DOMDocument();
        $doc->load(__DIR__.'/Fixtures/bookstore.xml');
        $reader = new XmlReader($doc);
        $reader
          ->setRecordXpath('//book')
          ->addField('title', 'string(./title/text())')
          ->addField('language', 'string(./title/@lang)')
          ->addField('price', 'string(./price/text())')
        ;

        return $reader;
    }
}
