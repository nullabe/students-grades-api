<?php

namespace StudentsGradesApi\Domain\Repository;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\Model\Student;

interface StudentRepositoryInterface
{
    public function get(UuidInterface $uuid): ?Student;

    public function add(Student $student): void;

    public function delete(Student $student): void;
}
