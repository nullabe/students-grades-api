<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\AddGradeToStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandInterface;

final class AddGradeToStudentCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private string $gradeSubject,
        private float $gradeValue
    ) {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getGradeSubject(): string
    {
        return $this->gradeSubject;
    }

    public function getGradeValue(): float
    {
        return $this->gradeValue;
    }
}
