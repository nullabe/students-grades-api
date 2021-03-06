<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\UseCase\Student;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\DeleteStudent\DeleteStudentCommand;
use StudentsGradesApi\Application\Command\DeleteStudent\DeleteStudentCommandHandler;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
use StudentsGradesApi\Tests\Utils\Stub\Domain\Model\StudentFactory;
use StudentsGradesApi\Tests\Utils\Stub\Infrastructure\Persistence\Repository\TestStudentRepository;

final class DeleteStudentTest extends TestCase
{
    public function test_delete_student_with_uuid_not_found(): void
    {
        $testStudentRepository = new TestStudentRepository();

        $deleteStudentCommandHandler = new DeleteStudentCommandHandler($testStudentRepository);

        $this->expectException(StudentNotFoundException::class);

        $deleteStudentCommandHandler->handle(new DeleteStudentCommand(Uuid::uuid4()));
    }

    public function test_delete_student(): void
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
