<?php

namespace Angetl\Reader;

use ArrayIterator;
use Angetl\Record;

class MemoryReader implements Reader
{
    /**
     * @var Iterator
     */
    protected $recordList;

    /**
     * @param mixed $recordList
     */
    public function __construct($recordList)
    {
        if (is_array($recordList)) {
            $this->recordList = new ArrayIterator($recordList);
        } elseif ($recordList instanceof IteratorAggregate) {
            $this->recordList = $recordList->getIterator();
        } elseif ($recordList instanceof Iterator) {
            $this->recordList = $recordList;
        } else {
            throw new \InvalidArgumentException('Invalid record list. MemoryReader accepts array, IteratorAggregate and Iterator.');
        }

        $this->recordList->rewind();
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        if ($this->recordList->valid()) {
            $record = $this->createRecord($this->recordList->current());
            $this->recordList->next();

            return $record;
        }

        return false;
    }

    /**
     * @param mixed $data
     * @return Record
     */
    protected function createRecord($data)
    {
        if ($data instanceof Record) {
            return $data;
        }

        if (is_array($data)) {
            return new Record($data);
        }

        throw new \Exception('Invalid record data type: '.gettype($data));
    }
}
