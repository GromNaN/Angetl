<?php

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
     * @var array Hashed footprint of records already filtered.
     */
    private $hashes;
    /**
     * @var array List of field names to check unicity.
     */
    protected $uniqueFieldNames;

    public function __construct($uniqueFieldNames = false)
    {
        $this->uniqueFieldNames = $uniqueFieldNames ? array_flip($uniqueFieldNames) : false;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Record $record)
    {
        $hash = $this->getHash($record->getValues());

        if ($key = array_search($hash, $this->hashes)) {
            $record->delete();
            $record->addMessage('Duplicate of {{ key }}', array('{{ key }}' => $key));
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
