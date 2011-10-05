<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\PdoReader;

class PdoReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testRead()
    {
        $reader = $this->getPdoReader();

        $expected = array(
            0 => array(
                'title' => 'Harry Potter',
                'language' => 'eng',
                'price' => '29.99',
            ),
            1 => array(
                'title' => 'Leçons de XML',
                'language' => 'fra',
                'price' => '39.95',
            ),
        );

        $reader->open();

        foreach ($expected as $i => $expect) {
            $record = $reader->read();
            $this->assertEquals($expect, $record, 'Record '.$i.' is read');
        }

        $this->assertNull($reader->read(), 'End of file');

        $reader->close();
    }

    protected function getPdoReader()
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
