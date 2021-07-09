<?php

namespace Angetl\Writer;

use Angetl\Record;

interface Writer
{
    /**
     * Write a record.
     *
     * @param Record $record Record to write.
     * @return void
     */
    function write(Record $record);
}
