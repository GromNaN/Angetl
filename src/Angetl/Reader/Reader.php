<?php

namespace Angetl\Reader;

use Angetl\Record;

interface Reader
{
    /**
     * Read the next record.
     *
     * return Record|bool The record read. false is returned at the end.
     */
    function read();
}
