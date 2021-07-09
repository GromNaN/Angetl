<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests;

use Angetl\Filter\MapFilter;
use Angetl\Processor;
use Angetl\Reader\MemoryReader;
use Angetl\Writer\NullWriter;
use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    public function testIterator()
    {
        $values = [
            ['foo' => 1],
            ['foo' => 2],
            ['foo' => 3],
            ['foo' => 4],
        ];

        $processor = new Processor();
        $processor
            ->setReader(new MemoryReader($values))
            ->setFilter(new MapFilter(['bar' => 'foo']))
            ->setWriter(new NullWriter())
        ;

        foreach ($processor as $key => $record) {
            $this->assertEquals($record->getValues(), ['foo' => $key, 'bar' => $key]);
        }
    }
}
