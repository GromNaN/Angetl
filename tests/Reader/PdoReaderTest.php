<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Reader;

use Angetl\Reader\PdoReader;

class PdoReaderTest extends ReaderTest
{
    protected $class = PdoReader::class;

    /**
     * @return \Angetl\Reader\PdoReader
     */
    protected function getReader()
    {
        $pdo = new \PDO(sprintf('sqlite:%s/Fixtures/bookstore.sqlite', __DIR__));
        $stmt = $pdo->prepare('SELECT * FROM bookstore');
        $stmt->execute();
        $reader = new PdoReader($stmt);
        $reader
            ->addField('title', 0)
            ->addField('language', 1)
            ->addField('price', 2)
        ;

        return $reader;
    }
}
