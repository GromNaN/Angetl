<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Reader;

use Angetl\Reader\XmlReader;

class XmlReaderTest extends ReaderTest
{
    public function testAddField()
    {
        $reader = $this->getReader();

        $fieldNames = ['title', 'language', 'price'];

        $this->assertEquals($fieldNames, $reader->getFieldNames(), 'Get field names');
    }

    protected function getReader(): XmlReader
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
