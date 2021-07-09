<?php

namespace Angetl;

class Record implements \ArrayAccess
{
    const FLAG_DELETED = 'deleted';
    const FLAG_INVALID = 'invalid';

    protected $values;
    protected $messages;
    protected $flags;

    public function __construct($values = null)
    {
        $this->values = array();
        $this->flags = array();
        $this->messages = array();
        if ($values) {
            $this->setValues($values);
        }
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

    public function hasMessages(): bool
    {
        return 0 !== count($this->messages);
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getFormattedMessages(): array
    {
        $messages = [];
        foreach ($this->messages as $message) {
            $messages[] = strtr($message['template'], $message['params']);
        }

        return $messages;
    }

    /**
     * @param string $message Message template
     * @param array  $params  Message parameters
     * @return Record
     */
    public function addMessage($template, $params = array())
    {
        $this->messages[] = array('template' => $template, 'params' => $params);
    }

    /**
     * Set flag value.
     *
     * @param string $name Flag name
     * @param mixed $value Flag value
     * @return Record
     */
    public function flag($name, $value = true)
    {
        $this->flags[$name] = $value;

        return $this;
    }

    /**
     * Get flag value.
     *
     * @param string $name Flag name
     * @param mixed $default Flag value by default if not set
     * @return mixed Flag value
     */
    public function is($name, $default = false)
    {
        return array_key_exists($name, $this->flags) ? $this->flags[$name] : $default;
    }

}
