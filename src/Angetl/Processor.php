<?php

namespace Angetl;

use Angetl\Reader\Reader;
use Angetl\Writer\Writer;
use Angetl\Record;

class Processor implements \Iterator
{

    /**
     * @var int Incremental key
     */
    private $key = 0;
    /**
     * @var Record Last processed record.
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
     * Constructor.
     */
    public function __construct()
    {
        $this->filters = array();
    }

    /**
     * @param Reader $reader
     * @return Processor
     */
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @param Filter $filter
     * @return Processor
     */
    public function setFilter(Filter $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param Writer $writer
     * @return Processor
     */
    public function setWriter(Writer $writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * @return Record
     * @see \Iterator::current()
     */
    public function current()
    {
        return $this->currentRecord;
    }

    /**
     * @return int
     * @see \Iterator::key()
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @return void
     * @see \Iterator::next()
     */
    public function next()
    {
        if ($record = $this->reader->read()) {
            $this->key++;
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
        throw new \LogicException('Angetl processor cannot be rewind.');
    }

}
