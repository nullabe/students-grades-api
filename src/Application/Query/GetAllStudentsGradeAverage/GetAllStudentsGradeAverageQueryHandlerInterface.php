<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage;

use StudentsGradesApi\Application\Query\StudentGradeAverageViewModel;

interface GetAllStudentsGradeAverageQueryHandlerInterface
{
    /**
     * @return array<int, StudentGradeAverageViewModel>
     */
    public function handle(GetAllStudentsGradeAverageQuery $getAllStudentsGradeAverageQuery): array;
}
