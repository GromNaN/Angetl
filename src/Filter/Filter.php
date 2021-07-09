<?php

namespace Angetl\Filter;

use Angetl\Record;

interface Filter
{
    /**
     * @param Record $record
     */
    function filter(Record $record);
}
