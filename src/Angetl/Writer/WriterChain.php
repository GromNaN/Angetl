<?php

namespace Angetl\Writer;

use Angetl\Record;

class WriterChain implements Writer
{
    private $writers;

    public function __construct(array $writers = array())
    {
        $this->writers = $writers;
    }

    /**
     * Add a writer to the chain.
     *
     * @param Writer $writer Writer to add
     * @return WriterChain Current writer chain.
     */
    public function add(Writer $writer)
    {
        $this->writer[] = $writer;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function write(Record $record)
    {
        foreach ($this->writers as $writer) {
            $writer->write($record);
        }
    }
}

