<?php

namespace Angetl;

class Record implements \ArrayAccess
{
    protected $values;
    protected $errors;
    protected $deleted;

    public function __construct($values = null)
    {
        $this->values = array();
        $this->errors = array();
        if ($values) {
            $this->setValues($values);
        }
        $this->deleted = false;
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
    public function delete()
    {
        $this->deleted = true;
    }
    public function isDeleted()
    {
        return $this->deleted;
    }
}
