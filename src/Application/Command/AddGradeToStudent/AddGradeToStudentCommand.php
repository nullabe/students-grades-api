<?php

namespace StudentsGradesApi\Application\Command\AddGradeToStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandInterface;

final class AddGradeToStudentCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $studentUuid,
        private string $studentGradeSubject,
        private int $studentGradeValue
    ) {
    }

    public function getStudentUuid(): UuidInterface
    {
        return $this->studentUuid;
    }

    public function getStudentGradeSubject(): string
    {
        return $this->studentGradeSubject;
    }

    public function getStudentGradeValue(): int
    {
        return $this->studentGradeValue;
    }
}