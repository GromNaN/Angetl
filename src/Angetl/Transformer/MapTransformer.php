<?php

namespace Angetl\Transformer;

use Angetl\Record;

/**
 * Mapping options can be a field name, a lambda function or a closure.
 */
class MapTransformer implements Transformer
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
    public function transform(array $recordList)
    {
        foreach ($recordList as $record) {
            $this->transformRecord($record);
        }
    }

    /**
     * Tranform one record.
     *
     * @param Record $record 
     */
    protected function transformRecord(Record $record)
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
