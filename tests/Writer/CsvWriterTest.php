<?php

namespace Angetl\Tests\Writer;

use Angetl\Writer\CsvWriter;
use Angetl\Record;
use PHPUnit\Framework\TestCase;

class CsvWriterTest extends TestCase
{
    public function testWriteHeader()
    {
        $handle = fopen('php://temp', 'w+');
        $writer = new CsvWriter(
            $handle,
            array(
                'title' => 'T',
                'language' => 'L',
                'price' => 'P',
            )
        );

        $writer->writeHeader();

        rewind($handle);
        $writtenLine = rtrim(fgets($handle), "\n");

        $this->assertEquals('title;language;price', $writtenLine);
    }

    public function testWrite()
    {
        $handle = fopen('php://temp', 'w+');
        $writer = new CsvWriter(
            $handle,
            array(
                'title' => 'title',
                'language' => 'language',
                'price' => 'price',
            ),
            array(
                'delimiter' => ':'
            )
        );

        $record = new Record(array(
            'title' => 'Harry Potter',
            'price' => 29.99,
        ));

        $writer->write($record);

        rewind($handle);
        $writtenLine = rtrim(fgets($handle), "\n");

        $this->assertEquals('"Harry Potter"::29.99', $writtenLine);
    }

    /**
     * return CsvWriter
     */
    protected function getWriter()
    {
        return $writer;
    }
}
