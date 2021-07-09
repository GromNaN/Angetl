<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Writer;

use Angetl\Record;
use SplQueue;

class WriterQueue implements Writer
{
    private \Angetl\Writer\Writer $writer;
    /**
     * @var SplQueue Record queue
     */
    private \SplQueue $queue;

    public function __construct(Writer $writer)
    {
        $this->writer = $writer;
        $this->queue = new SplQueue();
    }

    /**
     * @return WriterQueue
     */
    public function setWriter(Writer $writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function write(Record $record): void
    {
        $this->queue->enqueue($record);
    }

    /**
     * Write all queued records.
     *
     * @param int $max number of records to write
     *
     * @return WriterQueue
     */
    public function flush($max = -1)
    {
        while (0 !== $max-- && $record = $this->queue->dequeue()) {
            $this->writer->write($record);
        }

        return $this;
    }

    /**
     * Remove all records from the queue.
     *
     * @return WriterQueue
     */
    public function purge()
    {
        unset($this->queue);
        $this->queue = new SplQueue();

        return $this;
    }
}
