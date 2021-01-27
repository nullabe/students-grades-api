<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetStudentGradeAverage;

use StudentsGradesApi\Application\Query\StudentGradeAverageViewModel;

interface GetStudentGradeAverageQueryHandlerInterface
{
    public function handle(GetStudentGradeAverageQuery $getStudentGradeAverageQuery): StudentGradeAverageViewModel;
}
