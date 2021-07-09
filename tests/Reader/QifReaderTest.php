<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Reader;

use Angetl\Reader\QifReader;

class QifReaderTest extends ReaderTest
{
    protected function getReader(): QifReader
    {
        $handle = fopen(__DIR__.'/Fixtures/account.qif', 'r');
        $reader = new QifReader($handle);

        return $reader;
    }

    protected function getExpectedRecords()
    {
        return [
            [
                '!' => 'Type:Bank',
                'D' => '6/9\'2006',
                'T' => '0.00',
                'C' => 'X',
                'P' => 'Opening Balance',
                'L' => '[Direct West Oil]',
            ],
            [
                'D' => '7/9\'2006',
                'C' => 'X',
                'T' => '0.00',
                'XT' => '0.00',
                'P' => 'Opening Balance',
                'L' => 'Xfer from Delet',
            ],
            [
                'D' => '6/9\'2006',
                'T' => '-376,725,870.00',
                'P' => 'TD CanadaTrust DWOG',
                'L' => 'Issue to bearer',
            ],
        ];
    }

    public function testConstructWithInvalidResource()
    {
        $this->expectException(\InvalidArgumentException::class);
        new QifReader(123);
    }
}
