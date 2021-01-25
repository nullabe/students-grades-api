<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Utils\Stub\Infrastructure\Persistence\Repository;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;

final class TestStudentRepository implements StudentRepositoryInterface
{
    /** @var array<string, string> */
    private array $students = [];

    public function get(UuidInterface $uuid): ?Student
    {
        if (!array_key_exists($uuid->toString(), $this->students)) {
            return null;
        }

        $student = unserialize($this->students[$uuid->toString()]);

        if (!$student instanceof Student) {
            return null;
        }

        return $student;
    }

    public function add(Student $student): void
    {
        $this->students[$student->getUuid()->toString()] = serialize($student);
    }

    public function delete(Student $student): void
    {
        if (!array_key_exists($student->getUuid()->toString(), $this->students)) {
            return;
        }

        unset($this->students[$student->getUuid()->toString()]);
    }
}
