<?php

namespace Angetl\Filter;

use Angetl\Record;

interface Filter
{
    /**
     * @param Record $record
     */
    public function filter(Record $record);
}
