<?php

namespace Angetl;

class Record implements \ArrayAccess
{

    protected $values;
    protected $messages;
    protected $deleted;

    public function __construct($values = null)
    {
        $this->values = array();
        $this->messages = array();
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

    public function hasMessages()
    {
        return 0 !== count($this->messages);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param string $message Message template
     * @param mixed  $param1
     * @param mixed  $param2
     * @param mixed  $param3
     * @return Record
     */
    public function addMessage($template, $params = array())
    {
        $this->messages[] = array('template' => $template, 'params' => $params);
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
