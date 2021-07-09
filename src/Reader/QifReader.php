<?php

namespace Angetl\Reader;

use Angetl\Record;

/**
 * Read Quicken Interchange Format files
 * @link http://en.wikipedia.org/wiki/Quicken_Interchange_Format
 *
 * The first record is the file header.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class QifReader implements Reader
{

    /**
     * @var resource File handle
     */
    protected $handle;

    /**
     * Constructor.
     *
     * @param resource $handle File handle
     * @param array $options Options
     */
    public function __construct($handle)
    {
        $this->handle = $handle;
        if (!is_resource($handle)) {
            throw new \InvalidArgumentException('Invalid resource handle.');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        if (!feof($this->handle)) {

            $record = new Record();

            do {

                $line = fgets($this->handle);
                $line = rtrim($line, " \r\n");

                if (empty($line)) {
                    continue;
                }

                $code = strtoupper($line[0]);

                // Each record is ended with a ^ (caret)
                if ('^' === $code) {
                    break;
                }

                // X: Extended data for Quicken Business. Followed by a second character subcode
                if ('X' === $code && strlen($line) > 1) {
                    $code .= strtoupper($line[1]);
                }

                $record[$code] = substr($line, strlen($code));

            } while (!feof($this->handle));

            return (0 === count($record->getValues())) ? false : $record;
        }

        return false;
    }
}
