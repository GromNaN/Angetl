<?php

namespace Angetl\Writer;

use Angetl\Record;

class NullWriter implements Writer
{

    /**
     * {@inheritDoc}
     */
    public function write(Record $record)
    {
        // Do nothing.
    }
}
