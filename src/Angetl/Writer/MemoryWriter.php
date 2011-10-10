<?php

namespace Angetl\Reader;

use Angetl\Record;

class MemoryWriter implements Writer
{

    /**
     * @var array
     */
    protected $records;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->records = array();
    }

    /**
     * {@inheritDoc}
     */
    public function write(Record $record)
    {
        $this->records[] = $record;
    }

    /**
     * Get written records.
     *
     * @return array<Record>
     */
    public function getRecords()
    {
        return $this->recordList;
    }

}
