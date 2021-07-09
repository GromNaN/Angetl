<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Reader;

use Angetl\Record;
use ArrayIterator;

class MemoryReader implements Reader
{
    protected \Iterator $recordList;

    /**
     * @param array|\IteratorAggregate|\Iterator $recordList
     */
    public function __construct($recordList)
    {
        if (is_array($recordList)) {
            $this->recordList = new ArrayIterator($recordList);
        } elseif ($recordList instanceof \IteratorAggregate) {
            $this->recordList = $recordList->getIterator();
        } elseif ($recordList instanceof \Iterator) {
            $this->recordList = $recordList;
        } else {
            throw new \InvalidArgumentException('Invalid record list. MemoryReader accepts array, IteratorAggregate and Iterator.');
        }

        $this->recordList->rewind();
    }

    public function read(): ?Record
    {
        if ($this->recordList->valid()) {
            $record = $this->createRecord($this->recordList->current());
            $this->recordList->next();

            return $record;
        }

        return null;
    }

    /**
     * @param Record|array $data
     */
    protected function createRecord($data): Record
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
