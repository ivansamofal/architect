<?php

namespace App\Validator\Constraints;

use App\Service\ProfileService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEmailValidator extends ConstraintValidator
{
    public function __construct(private ProfileService $profileService)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueEmail) {
            throw new \InvalidArgumentException('Wrong constraint passed');
        }

        if (null === $value || '' === $value) {
            return;
        }

        $existing = $this->profileService->findOneBy(['email' => $value]);

        if ($existing) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
