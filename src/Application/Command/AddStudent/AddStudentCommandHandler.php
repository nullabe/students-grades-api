<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\AddStudent;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Application\Exception\InvalidCommandException;
use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;

/**
 * @implements CommandHandlerInterface<AddStudentCommand>
 */
final class AddStudentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    public function handle(CommandInterface $command): CommandResponseInterface
    {
        if (!$command instanceof AddStudentCommand) {
            throw new InvalidCommandException();
        }

        $student = new Student(
            Uuid::uuid4(),
            $command->getStudentFirstName(),
            $command->getStudentLastName(),
            $command->getStudentBirthDate()
        );

        $this->studentRepository->add($student);

        return new AddStudentCommandResponse($student->getUuid());
    }

    public static function listenTo(): string
    {
        return AddStudentCommand::class;
    }
}
