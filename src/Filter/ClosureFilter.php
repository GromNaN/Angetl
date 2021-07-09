<?php

namespace Angetl\Filter;

use Angetl\Record;

/**
 *
 */
class ClosureFilter implements Filter
{
    protected $closures;

    public function __construct(array $closures = array())
    {
        $this->closures = $closures;
    }

    public function setClosure($fieldName, $closure)
    {
        $this->closures[$fieldName] = $closure;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Record $record)
    {
        foreach ($this->closures as $fieldName => $closure) {
            $record[$fieldName] = $closure($record[$fieldName]);
        }
    }
}
