<?php

namespace Angetl\Reader;

use ArrayIterator;

class MemoryReader extends AbstractReader
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
    }

    protected function _open()
    {
        $this->recordList->rewind();
    }

    protected function _read()
    {
        if ($this->recordList->valid()) {
            $this->currentRecord = $this->recordList->current();
            $this->recordList->next();

            return true;
        }

        return false;
    }

    protected function _close()
    {
        // Nothing to do
    }
}
