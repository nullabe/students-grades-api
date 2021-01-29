<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetStudentGradeAverage;

interface GetStudentGradeAverageQueryHandlerInterface
{
    public function handle(GetStudentGradeAverageQuery $getStudentGradeAverageQuery): GetStudentGradeAverageViewModel;
}
