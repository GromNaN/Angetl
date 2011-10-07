<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\PdoReader;

class PdoReaderTest extends ReaderTest
{
    protected $class = 'PdoReader';

    /**
     * @return \Angetl\Reader\PdoReader
     */
    protected function getReader()
    {
        $pdo = new \PDO(sprintf('sqlite:%s/Fixtures/bookstore.sqlite', __DIR__));
        $stmt = $pdo->prepare('SELECT * FROM bookstore');
        $reader = new PdoReader($stmt);
        $reader
            ->addField('title', 0)
            ->addField('language', 1)
            ->addField('price', 2)
        ;

        return $reader;
    }
}
