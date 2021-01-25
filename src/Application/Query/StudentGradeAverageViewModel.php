<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\Model\Student;

final class StudentGradeAverageViewModel implements ViewModelInterface
{
    private UuidInterface $studentUuid;

    private float $studentGradeAverage;

    public function __construct(Student $student)
    {
        $this->studentUuid = $student->getUuid();
        $this->studentGradeAverage = $student->getGradeAverage();
    }

    public function getStudentUuid(): UuidInterface
    {
        return $this->studentUuid;
    }

    public function getStudentGradeAverage(): float
    {
        return $this->studentGradeAverage;
    }
}
