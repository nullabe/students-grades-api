<?php

namespace StudentsGradesApi\Domain\Model;

use Ramsey\Uuid\UuidInterface;

final class Student
{
    public function __construct(
        private UuidInterface $uuid,
        private string $firstName,
        private string $lastName,
        private \DateTimeInterface $birthDate
    ) {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
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
