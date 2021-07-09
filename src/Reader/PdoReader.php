<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Reader;

use Angetl\Record;

class PdoReader extends AbstractReader
{
    protected \PDOStatement $stmt;

    /**
     * @var Fetch mode \PDO::FETCH_*
     */
    protected int $fetchMode;

    /**
     * @param \PDOStatement $stmt Executed statement
     * @param int $fetchMode Fetch mode \PDO::FETCH_*
     */
    public function __construct($stmt, int $fetchMode = \PDO::FETCH_BOTH)
    {
        $this->stmt = $stmt;
        $this->fetchMode = $fetchMode;
    }

    public function read(): ?Record
    {
        if ($row = $this->stmt->fetch($this->fetchMode)) {
            $record = new Record();

            if ($this->fields) {
                foreach ($this->fields as $fieldName => $key) {
                    $record[$fieldName] = $row[$key] ?? null;
                }
            } else {
                $record->setValues($row);
            }

            return $record;
        }

        return null;
    }
}
