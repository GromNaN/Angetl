<?php

namespace Angetl;

abstract class AbstractReader
{
    protected $fieldNames;
    protected $currentRecord = null;
    protected $opened = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fieldNames = array();
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

    /**
     * Read next record
     *
     * @return
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

    abstract protected function _read();

    abstract protected function _close();

    abstract protected function _open();

    /**
     * Create a new current record.
     */
    protected function _newRecord()
    {
        $this->currentRecord = array_fill_keys($this->fieldNames, null);
    }

    /**
     * @return array Current record
     */
    public function getCurrentRecord()
    {
        return $this->currentRecord;
    }

    /**
     * @return array Field names
     */
    public function getFieldNames()
    {
        return $this->fieldNames;
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
