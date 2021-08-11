<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Filter;

use Angetl\Filter\Filter;
use Angetl\Filter\FilterChain;
use Angetl\Record;
use PHPUnit\Framework\TestCase;

class FilterChainTest extends TestCase
{
    public function testEmptyChain(): void
    {
        $filter = new FilterChain();
        $values = ['foo' => 'bar'];
        $record = new Record($values);

        $filter->filter($record);

        $this->assertSame($values, $record->getValues());
    }

    public function testAllFiltersAreCalled(): void
    {
        $record = new Record();
        $filter1 = $this->createMock(Filter::class);
        $filter1
            ->expects($this->once())
            ->method('filter')
            ->with($record)
            ->willReturnCallback(function (Record $record) {
                $record['filter1'] = true;
            })
        ;
        $filter2 = $this->createMock(Filter::class);
        $filter2
            ->expects($this->once())
            ->method('filter')
            ->with($record)
            ->willReturnCallback(function (Record $record) {
                $this->assertTrue($record['filter1']);
                $record['filter2'] = true;
            })
        ;

        $filter = new FilterChain([
            $filter1,
            $filter2,
        ]);

        $filter->filter($record);

        $this->assertSame(['filter1' => true, 'filter2' => true], $record->getValues());
    }

    /**
     * @dataProvider getInvalidFlags
     */
    public function testInvalidRecordsSkipped(string $flag): void
    {
        $record = new Record();
        $filter1 = $this->createMock(Filter::class);
        $filter1
            ->expects($this->once())
            ->method('filter')
            ->with($record)
            ->willReturnCallback(function (Record $record) use ($flag) {
                $record->flag($flag);
            })
        ;
        $filter2 = $this->createMock(Filter::class);
        $filter2
            ->expects($this->never())
            ->method('filter')
        ;

        $filter = new FilterChain([
            $filter1,
            $filter2,
        ]);

        $filter->filter($record);

        $this->assertTrue($record->is($flag));
    }

    public function getInvalidFlags(): iterable
    {
        return [
            [Record::FLAG_DELETED],
            [Record::FLAG_INVALID],
        ];
    }
}
