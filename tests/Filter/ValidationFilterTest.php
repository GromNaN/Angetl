<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Tests\Filter;

use Angetl\Filter\ValidationFilter;
use Angetl\Record;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as C;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Mapping\BlackholeMetadataFactory;
use Symfony\Component\Validator\Validator;

class ValidationFilterTest extends TestCase
{
    /**
     * @dataProvider dataForFilterTest
     */
    public function testFilter($values, $messages, $invalid)
    {
        $filter = $this->getFilter();
        $filter->setConstraint(new C\Collection([
            'email' => new C\Email(),
            'url' => [new C\Url(), new C\Length(['max' => 15])],
        ]));

        $record = new Record($values);

        $filter->filter($record);

        $this->assertSame($record->is(Record::FLAG_INVALID), $invalid);
        $this->assertSame($record->getFormattedMessages(), $messages);
        $this->assertCount(count($messages), $record->getMessages());
    }

    public function dataForFilterTest()
    {
        return [
            [
                [
                    'email' => 'test@email.com',
                    'url' => 'http://foo.bar/',
                ],
                [],
                false,
            ],
            [
                [
                    'email' => 'http://foo.bar/baz',
                    'url' => 'test@email.com',
                ],
                [
                    '[email] This value is not a valid email address.',
                    '[url] This value is not a valid URL.',
                ],
                true,
            ],
            [
                [
                    'email' => 'test@email.com',
                ],
                [
                    '[url] This field is missing.',
                ],
                true,
            ],
        ];
    }

    /**
     * @return ValidationFilter
     */
    protected function getFilter()
    {
        $filter = new ValidationFilter();

        return $filter;
    }
}
