<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Reader;

use Angetl\Reader\CsvFileReader;

class CsvFileReaderTest extends ReaderTest
{
    protected $class = CsvFileReader::class;

    public function dataForTestRead()
    {
        $reader1 = new CsvFileReader(__DIR__.'/Fixtures/bookstore1.csv');

        $reader2 = new CsvFileReader(__DIR__.'/Fixtures/bookstore2.csv', [
            'delimiter' => ':',
            'names_first' => false,
            'skip' => 4,
        ]);
        $reader2->addField('title', 2);
        $reader2->addField('language', 0);
        $reader2->addField('price', 3);

        return [
            [$reader1],
            [$reader2],
        ];
    }

    public function testConstructWithInvalidFilename()
    {
        $this->expectException(\InvalidArgumentException::class);
        new CsvFileReader(__DIR__.'/invalid');
    }
}
