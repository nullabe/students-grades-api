<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query;

use StudentsGradesApi\Domain\Model\Student;

final class StudentGradeAverageViewModel implements ViewModelInterface
{
    private string $uuid;

    private float $gradeAverage;

    public function __construct(Student $student)
    {
        $this->uuid = $student->getUuid()->toString();
        $this->gradeAverage = $student->getGradeAverage();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getGradeAverage(): float
    {
        return $this->gradeAverage;
    }
}
