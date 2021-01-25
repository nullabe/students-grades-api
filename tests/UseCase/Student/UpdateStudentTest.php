<?php

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use StudentsGradesApi\Application\Command\UpdateStudent\UpdateStudentCommand;
use StudentsGradesApi\Application\Command\UpdateStudent\UpdateStudentCommandHandler;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;
use StudentsGradesApi\Tests\Utils\Stub\Infrastructure\Persistence\Repository\TestStudentRepository;

class UpdateStudentTest extends TestCase
{
    public function testUpdateStudent(): void
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
