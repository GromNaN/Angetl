<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Reader;

use Angetl\Record;
use PHPUnit\Framework\TestCase;

abstract class ReaderTest extends TestCase
{
    protected $class = '';

    /**
     * @dataProvider dataForTestRead
     */
    public function testRead($reader)
    {
        foreach ($this->getExpectedRecords() as $i => $expect) {
            $record = $reader->read();
            $this->assertInstanceOf(Record::class, $record, $this->class.'::read() returns a Record object');
            $this->assertEquals($expect, $record->getValues(), $this->class.'::read() Record '.$i.' is read');
        }

        $this->assertFalse($reader->read(), 'End of file');
        $this->assertFalse($reader->read(), 'End of file');
    }

    public function dataForTestRead()
    {
        return [[$this->getReader()]];
    }

    /**
     * @return array
     */
    protected function getExpectedRecords()
    {
        return [
            0 => [
                'title' => 'Harry Potter',
                'language' => 'eng',
                'price' => '29.99',
            ],
            1 => [
                'title' => 'Leçons de XML',
                'language' => 'fra',
                'price' => '39.95',
            ],
        ];
    }
}
