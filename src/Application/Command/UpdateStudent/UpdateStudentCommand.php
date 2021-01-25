<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\UpdateStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandInterface;

final class UpdateStudentCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $studentUuid,
        private ?string $studentFirstName = null,
        private ?string $studentLastName = null,
        private ?\DateTimeInterface $studentBirthDate = null
    ) {
    }

    public function getStudentUuid(): UuidInterface
    {
        return $this->studentUuid;
    }

    public function getStudentFirstName(): ?string
    {
        return $this->studentFirstName;
    }

    public function getStudentLastName(): ?string
    {
        return $this->studentLastName;
    }

    public function getStudentBirthDate(): ?\DateTimeInterface
    {
        return $this->studentBirthDate;
    }
}
