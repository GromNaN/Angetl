<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Filter;

use Angetl\Record;

/**
 * Unique filter.
 *
 * Delete all duplicate records. Unicity contraints can be defined on a list of given field names.
 *
 * @todo Provide different storages for hashes (sqlite, memcache ???)
 */
class UniqueFilter
{
    /**
     * @var array hashed footprint of records already filtered
     */
    private $hashes;
    /**
     * @var array list of field names to check unicity
     */
    protected $uniqueFieldNames;

    public function __construct($uniqueFieldNames = false)
    {
        $this->uniqueFieldNames = $uniqueFieldNames ? array_flip($uniqueFieldNames) : false;
    }

    public function filter(Record $record)
    {
        $hash = $this->getHash($record->getValues());

        if ($key = array_search($hash, $this->hashes)) {
            $record->setFlag(Record::FLAG_DELETED);
            $record->addMessage('Duplicate of {{ key }}', ['{{ key }}' => $key]);
        }

        $this->hashes[] = $hash;
    }

    /**
     * Create an unique hash fot the given values.
     *
     * @param array $values
     */
    protected function getHash($values)
    {
        if ($this->uniqueFieldNames) {
            $values = array_intersect_key($values, $this->uniqueFieldNames);
        }

        return sha1(json_encode($values), true);
    }
}
