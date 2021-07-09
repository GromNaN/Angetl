<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Writer;

use Angetl\Record;
use Angetl\Writer\CsvWriter;
use PHPUnit\Framework\TestCase;

class CsvWriterTest extends TestCase
{
    public function testWriteHeader()
    {
        $handle = fopen('php://temp', 'w+');
        $writer = new CsvWriter(
            $handle,
            [
                'title' => 'T',
                'language' => 'L',
                'price' => 'P',
            ]
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
            [
                'title' => 'title',
                'language' => 'language',
                'price' => 'price',
            ],
            [
                'delimiter' => ':',
            ]
        );

        $record = new Record([
            'title' => 'Harry Potter',
            'price' => 29.99,
        ]);

        $writer->write($record);

        rewind($handle);
        $writtenLine = rtrim(fgets($handle), "\n");

        $this->assertEquals('"Harry Potter"::29.99', $writtenLine);
    }
}
