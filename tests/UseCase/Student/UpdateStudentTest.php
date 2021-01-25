<?php

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\UpdateStudent\UpdateStudentCommand;
use StudentsGradesApi\Application\Command\UpdateStudent\UpdateStudentCommandHandler;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;
use StudentsGradesApi\Tests\Utils\Stub\Infrastructure\Persistence\Repository\TestStudentRepository;

final class UpdateStudentTest extends TestCase
{
    public function test_update_student_with_uuid_not_found(): void
    {
        $testStudentRepository = new TestStudentRepository();

        $updateStudentCommandHandler = new UpdateStudentCommandHandler($testStudentRepository);

        $this->expectException(StudentNotFoundException::class);

        $updateStudentCommandHandler->handle(new UpdateStudentCommand(Uuid::uuid4()));
    }

    public function test_update_student(): void
    {
        $studentStub = StudentFactory::getStudent();

        $testStudentRepository = new TestStudentRepository();
        $testStudentRepository->add($studentStub);

        $updateStudentCommandHandler = new UpdateStudentCommandHandler($testStudentRepository);

        $commandResponse = $updateStudentCommandHandler->handle(new UpdateStudentCommand($studentStub->getUuid(), 'Antonio', 'Belluardo', new \DateTime('12-11-1990')));

        if (null === $commandResponseValue = $commandResponse->getValue()) {
            throw new \Exception('Response should be the updated student uuid');
        }

        if (null === $student = $testStudentRepository->get($commandResponseValue)) {
            throw new \Exception('Student should not be null');
        }

        $this->assertEquals('Antonio', $student->getFirstName());
        $this->assertEquals('Belluardo', $student->getLastName());
        $this->assertEquals(new \DateTime('12-11-1990'), $student->getBirthDate());
    }
}
