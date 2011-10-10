<?php

namespace Angetl\Writer;

use SplQueue;
use Angetl\Record;

class WriterQueue implements Writer
{

    /**
     * @var Writer
     */
    private $writer;
    /**
     * @var SplQueue Record queue
     */
    private $queue;

    public function __construct(Writer $writer)
    {
        $this->writer = $writer;
        $this->queue = new SplQueue();
    }

    /**
     * @param Writer $writer
     *
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
    public function write(Record $record)
    {
        $this->queue->enqueue($record);
    }

    /**
     * Write all queued records.
     *
     * @param int $max Number of records to write.
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

