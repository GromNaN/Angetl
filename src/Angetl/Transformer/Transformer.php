<?php

namespace Angetl\Transformer;

use Angetl\Record;

interface Transformer
{
    /**
     * @return array<Record>
     */
    function transform(array $recordList);
}
