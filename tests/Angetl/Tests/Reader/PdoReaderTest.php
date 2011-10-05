<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\XmlReader;

class XmlReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testRead()
    {
        $reader = $this->getXmlReader();

        $expected = array(
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

        $reader->open();

        foreach ($expected as $i => $expect) {
            $record = $reader->read();
            $this->assertEquals($expect, $record, 'Record '.$i.' is read');
        }

        $this->assertNull($reader->read(), 'End of file');

        $reader->close();
    }

    public function testAddField()
    {
        $reader = $this->getXmlReader();

        $fieldNames = array('title', 'language', 'price');

        $this->assertEquals($fieldNames, $reader->getFieldNames(), 'Get field names');
    }

    protected function getXmlReader()
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
