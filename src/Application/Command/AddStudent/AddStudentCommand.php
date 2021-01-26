<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\AddStudent;

use StudentsGradesApi\Application\Command\CommandInterface;

final class AddStudentCommand implements CommandInterface
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private \DateTimeInterface $birthDate
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }
}
