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

class WriterChain implements Writer
{
    private $writers;

    public function __construct(array $writers = [])
    {
        $this->writers = $writers;
    }

    /**
     * Add a writer to the chain.
     *
     * @param Writer $writer Writer to add
     *
     * @return WriterChain current writer chain
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
