<?php

namespace Angetl\Reader;

use Angetl\Record;

class PdoReader extends AbstractReader
{

    /**
     * @var \PDOStatement
     */
    protected $stmt;
    /**
     * @var int Fetch mode \PDO::FETCH_*
     */
    protected $fetch;

    /**
     * @param \PDOStatement $stmt Executed statement
     * @param int $fetchMode Fetch mode \PDO::FETCH_*
     */
    public function __construct($stmt, $fetchMode = \PDO::FETCH_BOTH)
    {
        parent::__construct();
        $this->stmt = $stmt;
        $this->fetchMode = $fetchMode;
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        if ($row = $this->stmt->fetch($this->fetchMode)) {
            $record = new Record();

            if ($this->fields) {
                foreach ($this->fields as $fieldName => $key) {
                    $record[$fieldName] = isset($row[$key]) ? $row[$key] : null;
                }
            } else {
                $record->setValues($row);
            }

            return $record;
        }

        return false;
    }

}
