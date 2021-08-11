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
    private array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function add(Filter $filter): self
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Record $record): void
    {
        foreach ($this->filters as $filter) {
            if (false !== $record->is(Record::FLAG_DELETED) || false !== $record->is(Record::FLAG_INVALID)) {
                return;
            }

            $filter->filter($record);
        }
    }
}
