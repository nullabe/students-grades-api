<?php

namespace StudentsGradesApi\Domain\ValueObject;

class Grade
{
    public function __construct(
        private string $subject,
        private int $value
    ) {
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
