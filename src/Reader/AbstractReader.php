<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Reader;

abstract class AbstractReader implements Reader
{
    protected array $fields = [];

    public function addField(string $fieldName, $field = null): self
    {
        $this->fields[$fieldName] = $field;

        return $this;
    }

    public function getFieldNames(): array
    {
        return array_keys($this->fields);
    }
}
