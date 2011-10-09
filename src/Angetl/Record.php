<?php

namespace Angetl;

class Record implements \ArrayAccess
{
    protected $values;
    protected $errors;

    public function __construct(array $fieldNames, $values = null)
    {
        $this->values = array_fill_keys($fieldNames, null);
        $this->errors = array();
        if ($values) {
            $this->setValues($values);
        }
    }

    public static function create(array $fieldNames, $values = null)
    {
        return new self($fieldNames, $values);
    }

    public static function createFromValues(array $values)
    {
        return new self(array_keys($values), $values);
    }

    public function setValues($values)
    {
        $this->values = array_merge($this->values, $values);

        return $this;
    }
    public function getValues()
    {
        return $this->values;
    }
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->values);
    }
    public function offsetGet($key)
    {
        return $this->values[$key];
    }
    public function offsetSet($key, $value)
    {
        $this->values[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($this->values[$key]);
    }

    public function isValid()
    {
        return empty($this->errors);
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function addError($errorMessage)
    {
        $this->errors[] = $errorMessage;

        return $this;
    }
}
