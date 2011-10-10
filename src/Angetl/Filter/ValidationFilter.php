<?php

namespace Angetl\Filter;

use Angetl\Record;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * Symfony2 validation.
 */
class ValidationFilter implements Filter
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var Constraint
     */
    protected $constraint;

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function setConstraint(Constraint $constraint)
    {
        $this->constraint = $constraint;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Record $record)
    {
        $violations = $this->validator->validateValue($record->getValues(), $this->constraint);

        if (empty($violations)) {
            return;
        }

        foreach ($violations as $violation) {
            $record->addMessage(
                '{{ property }} ' . $violation->getMessageTemplate(),
                $violation->getMessageParameters() + array('{{ property }}' => $violation->getPropertyPath())
            );
        }
    }
}
