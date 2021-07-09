<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl;

use Angetl\Filter\Filter;
use Angetl\Reader\Reader;
use Angetl\Writer\Writer;

class Processor implements \Iterator
{
    private int $key = 0;
    private ?Record $currentRecord = null;
    private Reader $reader;
    private Writer $writer;
    private Filter $filter;

    public function setReader(Reader $reader): self
    {
        $this->reader = $reader;

        return $this;
    }

    public function setFilter(Filter $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function setWriter(Writer $writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    public function current(): ?Record
    {
        return $this->currentRecord;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function next(): void
    {
        if ($record = $this->reader->read()) {
            ++$this->key;
            $this->currentRecord = $record;
            if ($this->filter) {
                $this->filter->filter($record);
            }
            $flagDeleted = $record->is(Record::FLAG_DELETED);
            if (!$flagDeleted) {
                $this->writer->write($record);
            }

            return;
        }

        $this->currentRecord = null;
    }

    public function valid(): bool
    {
        return null !== $this->currentRecord;
    }

    public function rewind(): void
    {
        $this->key = 0;
        $this->next();
    }
}
