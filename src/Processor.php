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
use Angetl\Record;
use Angetl\Writer\Writer;

class Processor implements \Iterator
{
    /**
     * @var int Incremental key
     */
    private $key;
    /**
     * @var Record last processed record
     */
    private $currentRecord;
    /**
     * @var Reader
     */
    private $reader;
    /**
     * @var Writer
     */
    private $writer;
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @return Processor
     */
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @return Processor
     */
    public function setFilter(Filter $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @return Processor
     */
    public function setWriter(Writer $writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * @return Record
     *
     * @see \Iterator::current()
     */
    public function current()
    {
        return $this->currentRecord;
    }

    /**
     * @return int
     *
     * @see \Iterator::key()
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @return void
     *
     * @see \Iterator::next()
     */
    public function next()
    {
        if ($record = $this->reader->read()) {
            ++$this->key;
            $this->currentRecord = $record;
            if ($this->filter) {
                $this->filter->filter($record);
            }
            if (!$record->is(Record::FLAG_DELETED)) {
                $this->writer->write($record);
            }

            return $record;
        }

        return $this->currentRecord = false;
    }

    public function valid()
    {
        return false !== $this->currentRecord;
    }

    /**
     * @throw \LogicException
     */
    public function rewind()
    {
        $this->key = 0;
        $this->next();
    }
}
