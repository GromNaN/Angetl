<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\MemoryReader;

class MemoryReaderTest extends ReaderTest
{
    protected $class = 'MemoryReader';

    /**
     * @return \Angetl\Reader\MemoryReader
     */
    protected function getReader()
    {
        $reader = new MemoryReader($this->getExpectedRecords());
        $reader
            ->addField('title')
            ->addField('language')
            ->addField('price')
        ;

        return $reader;
    }
}
