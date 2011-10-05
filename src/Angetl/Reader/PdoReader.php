<?php

namespace Angetl\Reader;

use Angetl\AbstractReader;

class PdoReader extends AbstractReader
{
    protected $fields;

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

    /**
     *
     * @param type $fieldName
     */
    public function addField($fieldName, $key)
    {
        $this->fieldNames[] = $fieldName;
        $this->fields[$fieldName] = $key;

        return $this;
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
