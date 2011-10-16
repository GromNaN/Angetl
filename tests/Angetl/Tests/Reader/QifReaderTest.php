<?php

namespace Angetl\Tests\Reader;

use Angetl\Reader\QifReader;

class QifReaderTest extends ReaderTest
{
    protected $class = 'QifReader';

    /**
     * @return \Angetl\Reader\QifReader
     */
    protected function getReader()
    {
        $handle = fopen(__DIR__.'/Fixtures/account.qif', 'r');
        $reader = new QifReader($handle);

        return $reader;
    }

    protected function getExpectedRecords()
    {
        return array(
            array(
                '!' => 'Type:Bank',
                'D' => '6/9\'2006',
                'T' => '0.00',
                'C' => 'X',
                'P' => 'Opening Balance',
                'L' => '[Direct West Oil]',
            ),
            array(
                'D' => '7/9\'2006',
                'C' => 'X',
                'T' => '0.00',
                'XT' => '0.00',
                'P' => 'Opening Balance',
                'L' => 'Xfer from Delet',
            ),
            array(
                'D' => '6/9\'2006',
                'T' => '-376,725,870.00',
                'P' => 'TD CanadaTrust DWOG',
                'L' => 'Issue to bearer',
            ),
        );
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructWithInvalidResource()
    {
        new QifReader(123);
    }
}
