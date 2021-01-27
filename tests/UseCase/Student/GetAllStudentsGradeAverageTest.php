<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageQuery;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;

final class GetAllStudentsGradeAverageTest extends TestCase
{
    public function test_get_all_students_grade_average_query_construct(): void
    {
        $studentStub1 = StudentFactory::getStudent();
        $studentStub2 = StudentFactory::getStudent();

        $getAllStudentsGradeAverageQuery = new GetAllStudentsGradeAverageQuery([
            $studentStub1->getUuid(),
            $studentStub2->getUuid(),
        ]);

        $this->assertCount(2, $getAllStudentsGradeAverageQuery->getUuid());
    }
}
