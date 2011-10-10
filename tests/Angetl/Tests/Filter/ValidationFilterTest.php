<?php

namespace Angetl\Tests\Filter;

use Angetl\Record;
use Angetl\Filter\ValidationFilter;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Mapping\BlackholeMetadataFactory;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Constraints as C;

class ValidationFilterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataForFilterTest
     */
    public function testFilter($values, $nbMessages)
    {
        $filter = $this->getFilter();
        $filter->setConstraint(new C\Collection(array(
            'email' => new C\Email(),
            'url' => new C\Url(),
        )));

        $record = new Record($values);

        $filter->filter($record);

        $this->assertEquals(count($record->getMessages()), $nbMessages);
    }

    public function dataForFilterTest()
    {
        return array(
            array(
                array(
                    'email' => 'test@email.com',
                    'url' => 'http://foo.bar/',
                ),
                0
            ),
            array(
                array(
                    'email' => 'http://foo.bar/',
                    'url' => 'test@email.com',
                ),
                2,
            ),
            array(
                array(
                    'email' => 'test@email.com',
                ),
                1,
            ),
        );
    }

    /**
     * @return ValidationFilter
     */
    protected function getFilter()
    {
        $filter = new ValidationFilter();
        $filter->setValidator(
            new Validator(
                new BlackholeMetadataFactory(),
                new ConstraintValidatorFactory(),
                array()
            )
        );

        return $filter;
    }

}
