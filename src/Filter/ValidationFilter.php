<?php

namespace Angetl\Filter;

use Angetl\Record;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Symfony validation.
 */
class ValidationFilter implements Filter
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Constraint
     */
    protected $constraint;

    public function __construct(ValidatorInterface $validator = null)
    {
        $this->validator = $validator ?? Validation::createValidator();
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
        $violations = $this->validator->validate($record->getValues(), $this->constraint);

        if (0 === $violations->count()) {
            return;
        }

        $record->flag(Record::FLAG_INVALID);

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $record->addMessage(
                '{{ property }} ' . $violation->getMessageTemplate(),
                $violation->getParameters() + array('{{ property }}' => $violation->getPropertyPath())
            );
        }
    }
}
