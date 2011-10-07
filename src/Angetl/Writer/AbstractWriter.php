<?php

namespace Angetl\Writer;

abstract class AbstractWriter implements Writer
{
    public function open()
    {
        $this->_open();
    }

    public function write($record)
    {
        $this->_write($record);
    }

    public function close()
    {
        $this->_close();
    }

    abstract protected function _open();
    abstract protected function _write($record);
    abstract protected function _close();
}
