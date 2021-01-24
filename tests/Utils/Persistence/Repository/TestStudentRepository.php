<?php

namespace StudentsGradesApi\Tests\Utils\Persistence\Repository;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;

final class TestStudentRepository implements StudentRepositoryInterface
{
    /** @var array<int, Student> */
    private array $students = [];

    public function get(UuidInterface $uuid): ?Student
    {
        foreach ($this->students as $storedStudent) {
            if ($uuid === $storedStudent->getUuid()) {
                return $storedStudent;
            }
        }

        return null;
    }

    public function add(Student $student): void
    {
        $this->students[] = $student;
    }

    public function delete(Student $student): void
    {
        foreach ($this->students as $index => $storedStudent) {
            if ($student === $storedStudent) {
                unset($this->students[$index]);
            }
        }
    }
}
