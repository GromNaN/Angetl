<?php

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
        $this->fields = array();
    }

    /**
     * @param string $fieldName Field name
     * @param mixed $field Field definition
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
