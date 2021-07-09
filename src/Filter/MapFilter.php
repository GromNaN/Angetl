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

/**
 * Mapping options can be a field name, a lambda function or a closure.
 */
class MapFilter implements Filter
{
    protected $mapping;

    /**
     * Constructor.
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
