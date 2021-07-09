<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Writer;

use Angetl\Record;

class MemoryWriter implements Writer
{
    protected array $records;

    public function __construct()
    {
        $this->records = [];
    }

    public function write(Record $record): void
    {
        $this->records[] = $record;
    }

    /**
     * Get written records.
     *
     * @return Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }
}
