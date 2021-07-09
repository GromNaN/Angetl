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

class CsvWriter implements Writer
{
    protected static $defaultOptions = [
        'delimiter' => ';',
        'enclosure' => '"',
    ];
    protected $options;

    /**
     * @var resource File handle
     */
    protected $handle;

    /**
     * @var array Fields definition like
     */
    protected $fields;

    public function __construct($handle, array $fields, array $options = [])
    {
        if (!is_resource($handle)) {
            throw new \InvalidArgumentException('CsvWriter::__construct() expects parameter 1 to be resource, %s given', $handle);
        }
        if (empty($fields)) {
            throw new \InvalidArgumentException('You must specify at lest 1 field.');
        }
        $this->handle = $handle;
        $this->fields = $fields;
        $this->options = array_merge(static::$defaultOptions, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function write(Record $record)
    {
        $fields = [];
        foreach ($this->fields as $fieldName => $sourceFieldName) {
            if (isset($record[$sourceFieldName])) {
                $fields[$fieldName] = strval($record[$sourceFieldName]);
            } else {
                $fields[$fieldName] = '';
            }
        }

        $ret = fputcsv($this->handle, $fields, $this->options['delimiter'], $this->options['enclosure']);

        if (false === $ret) {
            throw new \RuntimeException('Error writing line: %s', implode($this->options['delimiter'], $values));
        }
    }

    /**
     * Write columns names as header in the file.
     *
     * @return void
     */
    public function writeHeader()
    {
        $headers = array_keys($this->fields);

        $ret = fputcsv($this->handle, $headers, $this->options['delimiter'], $this->options['enclosure']);

        if (false === $ret) {
            throw new \RuntimeException('Error writing line: %s', implode($this->options['delimiter'], $values));
        }
    }
}
