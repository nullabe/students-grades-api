<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageViewModel;
use StudentsGradesApi\Domain\ValueObject\Grade;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;

final class GetAllStudentsGradeAverageTest extends TestCase
{
    public function test_get_all_students_grade_average_view_model_from_student(): void
    {
        $studentStub1 = (StudentFactory::getStudent())
            ->addGrade(new Grade('maths', 11))
            ->addGrade(new Grade('maths', 12))
            ->addGrade(new Grade('maths', 13))
        ;

        $studentStub2 = (StudentFactory::getStudent())
            ->addGrade(new Grade('maths', 11))
            ->addGrade(new Grade('maths', 12))
        ;

        $getAllStudentsGradeAverageViewModel = new GetAllStudentsGradeAverageViewModel([$studentStub1, $studentStub2]);

        $this->assertEquals(11.8, $getAllStudentsGradeAverageViewModel->getGradeAverage());
    }

    public function test_student_grade_average_view_model_from_student_with_no_students(): void
    {
        $getAllStudentsGradeAverageViewModel = new GetAllStudentsGradeAverageViewModel([]);

        $this->assertEquals(0.0, $getAllStudentsGradeAverageViewModel->getGradeAverage());
    }
}
