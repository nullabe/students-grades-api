<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\AddStudent;

use StudentsGradesApi\Application\Command\CommandInterface;

final class AddStudentCommand implements CommandInterface
{
    public function __construct(
        private string $studentFirstName,
        private string $studentLastName,
        private \DateTimeInterface $studentBirthDate
    ) {
    }

    public function getStudentFirstName(): string
    {
        return $this->studentFirstName;
    }

    public function getStudentLastName(): string
    {
        return $this->studentLastName;
    }

    public function getStudentBirthDate(): \DateTimeInterface
    {
        return $this->studentBirthDate;
    }
}
