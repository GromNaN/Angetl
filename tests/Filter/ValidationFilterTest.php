<?php

namespace Angetl\Tests\Filter;

use Angetl\Record;
use Angetl\Filter\ValidationFilter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Mapping\BlackholeMetadataFactory;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Constraints as C;

class ValidationFilterTest extends TestCase
{

    /**
     * @dataProvider dataForFilterTest
     */
    public function testFilter($values, $messages, $invalid)
    {
        $filter = $this->getFilter();
        $filter->setConstraint(new C\Collection(array(
            'email' => new C\Email(),
            'url' => [new C\Url(), new C\Length(['max' => 15])],
        )));

        $record = new Record($values);

        $filter->filter($record);

        $this->assertSame($record->is(Record::FLAG_INVALID), $invalid);
        $this->assertSame($record->getFormattedMessages(), $messages);
        $this->assertCount(count($messages), $record->getMessages());
    }

    public function dataForFilterTest()
    {
        return array(
            array(
                array(
                    'email' => 'test@email.com',
                    'url' => 'http://foo.bar/',
                ),
                [],
                false,
            ),
            array(
                array(
                    'email' => 'http://foo.bar/baz',
                    'url' => 'test@email.com',
                ),
                [
                    '[email] This value is not a valid email address.',
                    '[url] This value is not a valid URL.',
                ],
                true,
            ),
            array(
                array(
                    'email' => 'test@email.com',
                ),
                [
                    '[url] This field is missing.',
                ],
                true,
            ),
        );
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
