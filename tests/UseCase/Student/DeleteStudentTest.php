<?php

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\DeleteStudent\DeleteStudentCommand;
use StudentsGradesApi\Application\Command\DeleteStudent\DeleteStudentCommandHandler;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;
use StudentsGradesApi\Tests\Utils\Stub\Infrastructure\Persistence\Repository\TestStudentRepository;

final class DeleteStudentTest extends TestCase
{
    public function testDeleteStudentWithUuidNotFound(): void
    {
        $testStudentRepository = new TestStudentRepository();

        $deleteStudentCommandHandler = new DeleteStudentCommandHandler($testStudentRepository);

        $commandResponse = $deleteStudentCommandHandler->handle(new DeleteStudentCommand(Uuid::uuid4()));

        $this->assertNull($commandResponse->getValue());
    }

    public function testDeleteStudent(): void
    {
        $studentStub = StudentFactory::getStudent();

        $testStudentRepository = new TestStudentRepository();
        $testStudentRepository->add($studentStub);

        $deleteStudentCommandHandler = new DeleteStudentCommandHandler($testStudentRepository);

        $commandResponse = $deleteStudentCommandHandler->handle(new DeleteStudentCommand($studentStub->getUuid()));

        if (null === $commandResponseValue = $commandResponse->getValue()) {
            throw new \Exception('Response should be the deleted student uuid');
        }

        $this->assertNull($testStudentRepository->get($commandResponseValue));
    }
}
