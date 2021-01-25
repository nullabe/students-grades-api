<?php

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\AddGradeToStudent\AddGradeToStudentCommand;
use StudentsGradesApi\Application\Command\AddGradeToStudent\AddGradeToStudentCommandHandler;
use StudentsGradesApi\Application\Exception\InvalidGradeException;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;
use StudentsGradesApi\Tests\Utils\Stub\Infrastructure\Persistence\Repository\TestStudentRepository;

final class AddGradeToStudentTest extends TestCase
{
    public function test_add_grade_to_student_with_uuid_not_found(): void
    {
        $testStudentRepository = new TestStudentRepository();

        $addGradeToStudentCommandHandler = new AddGradeToStudentCommandHandler($testStudentRepository);

        $this->expectException(StudentNotFoundException::class);

        $addGradeToStudentCommandHandler->handle(new AddGradeToStudentCommand(Uuid::uuid4(), 'maths', 19));
    }

    public function test_add_grade_to_student(): void
    {
        $studentStub = StudentFactory::getStudent();

        $testStudentRepository = new TestStudentRepository();
        $testStudentRepository->add($studentStub);

        $addGradeToStudentCommandHandler = new AddGradeToStudentCommandHandler($testStudentRepository);

        $commandResponse = $addGradeToStudentCommandHandler->handle(new AddGradeToStudentCommand($studentStub->getUuid(), 'maths', 19));

        if (null === $commandResponseValue = $commandResponse->getValue()) {
            throw new \Exception('Response should be the updated student uuid');
        }

        if (null === $student = $testStudentRepository->get($commandResponseValue)) {
            throw new \Exception('Student should not be null');
        }

        $studentGrades = $student->getGrades();

        $this->assertCount(1, $studentGrades);

        if (null === $grade = array_pop($studentGrades)) {
            throw new \Exception('Grade should not be null');
        }

        $this->assertEquals('maths', $grade->getSubject());
        $this->assertEquals(19, $grade->getValue());
    }

    public function test_add_invalid_grade_to_student(): void
    {
        $studentStub = StudentFactory::getStudent();

        $testStudentRepository = new TestStudentRepository();
        $testStudentRepository->add($studentStub);

        $addGradeToStudentCommandHandler = new AddGradeToStudentCommandHandler($testStudentRepository);

        $this->expectException(InvalidGradeException::class);

        $addGradeToStudentCommandHandler->handle(new AddGradeToStudentCommand($studentStub->getUuid(), 'maths', 21));

        $this->expectException(InvalidGradeException::class);

        $addGradeToStudentCommandHandler->handle(new AddGradeToStudentCommand($studentStub->getUuid(), 'maths', -1));
    }
}
