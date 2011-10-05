<?php

namespace Angetl\Reader;

use Angetl\AbstractReader;

class PdoReader extends AbstractReader
{
    /**
     * @var \PDOStatement
     */
    protected $stmt;

    public function __construct($stmt = null)
    {
        parent::__construct();
        $this->fields = array();
        $this->stmt = $stmt;
    }

    protected function _open()
    {
        $this->stmt->execute();
    }

    protected function _read()
    {
        if ($row = $this->stmt->fetch(\PDO::FETCH_BOTH)) {
            foreach ($this->fields as $fieldName => $key) {
                $this->currentRecord[$fieldName] = isset($row[$key]) ? $row[$key] : null;
            }

            return true;
        }

        return false;
    }

    protected function _close()
    {
        unset($this->stmt);
    }
}
