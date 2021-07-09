<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Reader;

use Angetl\Record;

abstract class AbstractReader implements Reader
{
    /**
     * @var array Fields definition
     */
    protected $fields;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = [];
    }

    /**
     * @param string $fieldName Field name
     * @param mixed $field Field definition
     *
     * @return AbstractReader
     */
    public function addField($fieldName, $field = null)
    {
        $this->fields[$fieldName] = $field;

        return $this;
    }

    /**
     * @return array Field names
     */
    public function getFieldNames()
    {
        return array_keys($this->fields);
    }
}
