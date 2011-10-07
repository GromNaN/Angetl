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
     * @var array Current record
     */
    protected $currentRecord = null;

    /**
     * @var bool Is the reader opened
     */
    protected $opened = false;

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

    /**
     * Open reader
     *
     * @throw \LogicException When already opened
     * @api
     */
    public function open()
    {
        $this->_assertNotOpened();
        $this->_open();
        $this->opened = true;

        return $this;
    }

    /**
     * Read next record
     *
     * @return Record
     * @throw \LogicException When not opened
     * @api
     */
    public function read()
    {
        $this->_assertOpened();
        $this->_newRecord();

        if ($this->_read()) {
            return $this->currentRecord;
        } else {
            return null;
        }
    }

    /**
     * Close reader
     *
     * @throw \LogicException When not opened
     * @api
     */
    public function close()
    {
        $this->_assertOpened();
        $this->_close();
        $this->opened = false;

        return $this;
    }

    abstract protected function _read();

    abstract protected function _close();

    abstract protected function _open();

    /**
     * Create a new current record.
     */
    protected function _newRecord()
    {
        $this->currentRecord = new Record($this->getFieldNames());
    }

    /**
     * @return Record Current record
     */
    public function getCurrentRecord()
    {
        return $this->currentRecord;
    }

    /**
     * @throw \LogicException
     */
    protected function _assertOpened()
    {
        if (!$this->opened) {
            throw new \LogicException('Reader not opened.');
        }
    }

    /**
     * @throw \LogicException
     */
    protected function _assertNotOpened()
    {
        if ($this->opened) {
            throw new \LogicException('Reader already opened.');
        }
    }
}
