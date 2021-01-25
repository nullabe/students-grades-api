<?php

namespace StudentsGradesApi\Application\Command\UpdateStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandInterface;

final class UpdateStudentCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?\DateTimeInterface $birthDate = null
    ) {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }
}
