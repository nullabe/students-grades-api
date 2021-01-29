<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage;

interface GetAllStudentsGradeAverageQueryHandlerInterface
{
    public function handle(GetAllStudentsGradeAverageQuery $getAllStudentsGradeAverageQuery): GetAllStudentsGradeAverageViewModel;
}
