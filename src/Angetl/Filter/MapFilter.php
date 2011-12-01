<?php

namespace Angetl\Filter;

use Angetl\Record;

/**
 * Mapping options can be a field name, a lambda function or a closure.
 */
class MapFilter implements Filter
{
    protected $mapping;

    /**
     * Constructor.
     *
     * @param array $mapping
     */
    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Record $record)
    {
        foreach ($this->mapping as $fieldName => $map) {
            if (is_callable($map)) {
                $record[$fieldName] = $map($record);
                continue;
            }

            if ((is_numeric($map) || is_string($map)) && isset($record[$map])) {
                $record[$fieldName] = $record[$map];
            }
        }
    }
}
