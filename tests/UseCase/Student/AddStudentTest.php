<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use StudentsGradesApi\Application\Command\AddStudent\AddStudentCommand;
use StudentsGradesApi\Application\Command\AddStudent\AddStudentCommandHandler;
use StudentsGradesApi\Tests\Utils\Stub\Infrastructure\Persistence\Repository\TestStudentRepository;

final class AddStudentTest extends TestCase
{
    public function test_add_student(): void
    {
        $testStudentRepository = new TestStudentRepository();

        $addStudentCommandHandler = new AddStudentCommandHandler($testStudentRepository);

        $commandResponse = $addStudentCommandHandler->handle(
            new AddStudentCommand('Antoine', 'Belluard', new \DateTime('13-11-1990'))
        );

        if (null === $commandResponseValue = $commandResponse->getValue()) {
            throw new \Exception('Response should be the added student uuid');
        }

        if (null === $student = $testStudentRepository->get($commandResponseValue)) {
            throw new \Exception('Student should not be null');
        }

        $this->assertEquals('Antoine', $student->getFirstName());
        $this->assertEquals('Belluard', $student->getLastName());
        $this->assertEquals(new \DateTime('13-11-1990'), $student->getBirthDate());
    }
}
