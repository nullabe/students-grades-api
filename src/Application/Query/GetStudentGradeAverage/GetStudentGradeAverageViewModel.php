<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetStudentGradeAverage;

use StudentsGradesApi\Application\Query\ViewModelInterface;
use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\ValueObject\Grade;

final class GetStudentGradeAverageViewModel implements ViewModelInterface
{
    private string $uuid;

    private float $gradeAverage;

    public function __construct(Student $student)
    {
        $this->uuid = $student->getUuid()->toString();

        $this->gradeAverage = $this->getStudentGradeAverage($student);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getGradeAverage(): float
    {
        return $this->gradeAverage;
    }

    private function getStudentGradeAverage(Student $student): float
    {
        if (0 === count($student->getGrades())) {
            return 0.0;
        }

        $grades = array_sum(array_map(fn (Grade $grade) => $grade->getValue(), $student->getGrades()));

        return $grades / count($student->getGrades());
    }
}
