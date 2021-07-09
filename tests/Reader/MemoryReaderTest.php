<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Reader;

use Angetl\Reader\MemoryReader;

class MemoryReaderTest extends ReaderTest
{
    protected $class = MemoryReader::class;

    /**
     * @return \Angetl\Reader\MemoryReader
     */
    protected function getReader()
    {
        $reader = new MemoryReader($this->getExpectedRecords());

        return $reader;
    }
}
