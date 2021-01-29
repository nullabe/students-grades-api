<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use StudentsGradesApi\Application\Query\GetStudentGradeAverage\GetStudentGradeAverageQuery;
use StudentsGradesApi\Application\Query\GetStudentGradeAverage\GetStudentGradeAverageViewModel;
use StudentsGradesApi\Domain\ValueObject\Grade;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;

final class GetStudentGradeAverageTest extends TestCase
{
    public function test_get_student_grade_average_query_construct(): void
    {
        $studentStub = StudentFactory::getStudent();

        $getStudentGradeAverageQuery = new GetStudentGradeAverageQuery($studentStub->getUuid());

        $this->assertEquals($studentStub->getUuid(), $getStudentGradeAverageQuery->getUuid());
    }

    public function test_student_grade_average_view_model_from_student(): void
    {
        $studentStub = (StudentFactory::getStudent())
            ->addGrade(new Grade('maths', 12))
            ->addGrade(new Grade('maths', 11))
        ;

        $getStudentGradeAverageViewModel = new GetStudentGradeAverageViewModel($studentStub);

        $this->assertEquals($studentStub->getUuid()->toString(), $getStudentGradeAverageViewModel->getUuid());
        $this->assertEquals(11.5, $getStudentGradeAverageViewModel->getGradeAverage());
    }

    public function test_student_grade_average_view_model_from_student_with_no_grades(): void
    {
        $getStudentGradeAverageViewModel = new GetStudentGradeAverageViewModel(StudentFactory::getStudent());

        $this->assertEquals(0.0, $getStudentGradeAverageViewModel->getGradeAverage());
    }
}
