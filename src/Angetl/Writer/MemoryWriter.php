<?php

namespace Angetl\Reader;

use ArrayIterator;

class MemoryWriter extends AbstractWriter
{
    /**
     * @var ArrayIterator
     */
    protected $recordList;

    public function getRecordList()
    {
        return $this->recordList;
    }

    protected function _open()
    {
        $this->recordList = new ArrayIterator(array());
    }

    protected function _write($record)
    {
        $this->recordList->append($record);
    }

    protected function _close()
    {
        // Nothing to do
    }
}
