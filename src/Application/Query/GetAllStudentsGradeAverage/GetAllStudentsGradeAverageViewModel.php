<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage;

use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\ValueObject\Grade;

final class GetAllStudentsGradeAverageViewModel
{
    private float $gradeAverage = 0.0;

    /**
     * @param array<int, Student> $students
     */
    public function __construct(array $students)
    {
        $gradesSum = 0;
        $gradesCount = 0;

        foreach ($students as $student) {
            $gradesCount += count($student->getGrades());

            $gradesSum += $this->getStudentGradesSum($student->getGrades());
        }

        if (0 !== $gradesCount) {
            $this->gradeAverage = $gradesSum / $gradesCount;
        }
    }

    public function getGradeAverage(): float
    {
        return $this->gradeAverage;
    }

    /**
     * @param array<int, Grade> $grades
     */
    private function getStudentGradesSum(array $grades): float
    {
        $gradesSum = 0;

        foreach ($grades as $grade) {
            $gradesSum += $grade->getValue();
        }

        return $gradesSum;
    }
}
