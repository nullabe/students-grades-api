<?php

declare(strict_types=1);

namespace StudentsGradesApi\Domain\ValueObject;

class Grade
{
    public function __construct(
        private string $subject,
        private float $value
    ) {
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
