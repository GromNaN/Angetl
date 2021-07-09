<?php

namespace Angetl\Reader;

use Angetl\Record;
use Angetl\Utils\Encoding;

/**
 * CSV reader can parse and extract data from any Comma Separated Values text.
 * This reader is configurable to match your file format.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class CsvReader extends AbstractReader
{
    protected static $defaultOptions = array(
        'skip' => 0, // Number of lines to skip
        'names_first' => true, // The first line contains field names
        'delimiter' => null, // Delimiter. If null, il will be detected
        'encoding' => null, // Encoding. If null, il will be detected
        'length' => 4096, // Max line length
        'enclosure' => '"', // CSV enclosure
        'delimiters' => array(',', ';', "\t", '|'),
    );
    protected $handle;
    protected $firstLine;

    /**
     * Constructor.
     *
     * @param resource  $handle     File handle given by fopen() or fsockopen()
     * @param array     $options    Reader's options
     */
    public function __construct($handle, array $options = array())
    {
        parent::__construct();

        if (!is_resource($handle)) {
            throw new \InvalidArgumentException('Invalid resource handle');
        }

        $this->options = array_merge(static::$defaultOptions, $options);
        $this->handle = $handle;

        $this->initialize();
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        if ($line = fgets($this->handle, $this->options['length'])) {
            if (null === $delimiter = $this->options['delimiter']) {
                $this->options['delimiter'] = $delimiter = $this->detectDelimiter($line, $this->options['delimiters']);
            }
            if (null === $this->options['encoding'] && !Encoding::isUtf8($line)) {
                $line = Encoding::toUtf8($line);
            }
            $values = str_getcsv($line, $delimiter, $this->options['enclosure']);

            // First line contains field names
            if ($this->firstLine && empty($this->fields)) {
                $this->fields = array_flip($values);
                $this->firstLine = false;

                return $this->read();
            }

            $record = new Record();
            foreach ($this->fields as $fieldName => $key) {
                if (!array_key_exists($key, $values)) {
                    throw new \RuntimeException(sprintf('Invalid file format. Column "%s" missing in line "%"', $key, $line));
                }
                $record[$fieldName] = $values[$key];
            }

            return $record;
        }

        return false;
    }

    protected function initialize()
    {
        $this->firstLine = (bool) $this->options['names_first'];
        $this->skipLines($this->handle, $this->options['skip']);
    }

    /**
     * Move the cursor by the number of lines to skip
     *
     * @param resource $handle
     * @param int $skip
     */
    protected function skipLines($handle, $skip)
    {
        while ($skip > 0 && !feof($handle)) {
            $skip--;
            fgets($handle);
        }
    }

    /**
     * Detect the best delimitor for the given line.
     *
     * @param string $line
     * @return string
     * @throws \RuntimeException If the delimiter cannot be detected correctly.
     */
    protected function detectDelimiter($line, $delimiters)
    {
        $delimiterCount = -1;

        foreach ($delimiters as $d) {
            if ($delimiterCount < $c = substr_count($line, $d)) {
                $delimiter = $d;
                $delimiterCount = $c;
            }
        }

        $fieldsCount = count($this->fields);
        if ($delimiterCount < 1 || $fieldsCount && $delimiterCount < $fieldsCount) {
            throw new \RuntimeException(sprintf('Unable to detect CSV delimiter in: "%s" (checked %s)', $line, implode(' ', $delimiters)));
        }

        return $delimiter;
    }
}
