<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Filter;

use Angetl\Record;

class FilterChain implements Filter
{
    private $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Add a filter to the chain.
     *
     * @param Filter $filter Filter to add
     *
     * @return FilterChain current filter chain
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
