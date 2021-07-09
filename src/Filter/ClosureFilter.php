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

class ClosureFilter implements Filter
{
    protected array $closures;

    public function __construct(array $closures = [])
    {
        $this->closures = $closures;
    }

    public function setClosure($fieldName, $closure): void
    {
        $this->closures[$fieldName] = $closure;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Record $record): void
    {
        foreach ($this->closures as $fieldName => $closure) {
            $record[$fieldName] = $closure($record[$fieldName]);
        }
    }
}
