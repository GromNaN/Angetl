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
                $record[$fieldName] = call_user_func($map, $record);
                continue;
            }

            $record[$fieldName] = $record[$map];
        }
    }
}
