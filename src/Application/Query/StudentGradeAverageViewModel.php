<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\Model\Student;

final class StudentGradeAverageViewModel implements ViewModelInterface
{
    private UuidInterface $uuid;

    private float $gradeAverage;

    public function __construct(Student $student)
    {
        $this->uuid = $student->getUuid();
        $this->gradeAverage = $student->getGradeAverage();
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getGradeAverage(): float
    {
        return $this->gradeAverage;
    }
}
