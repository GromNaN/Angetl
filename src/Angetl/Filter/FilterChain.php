<?php

namespace Angetl\Filter;

use Angetl\Record;

class FilterChain implements Filter
{
    private $filters;

    public function __construct(array $filters = array())
    {
        $this->filters = $filters;
    }

    /**
     * Add a filter to the chain.
     *
     * @param Filter $filter Filter to add
     * @return FilterChain Current filter chain.
     */
    public function add(Filter $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Record $record)
    {
        foreach ($this->filters as $filter) {
            $filter->filter($record);
        }
    }
}

