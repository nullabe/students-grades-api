<?php

namespace StudentsGradesApi\Application\Command\AddStudent;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
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
            return new AddStudentCommandResponse();
        }

        $student = new Student(
            Uuid::uuid4(),
            $command->getFirstName(),
            $command->getLastName(),
            $command->getBirthDate()
        );

        $this->studentRepository->add($student);

        return new AddStudentCommandResponse($student->getUuid());
    }

    public static function listenTo(): string
    {
        return AddStudentCommand::class;
    }
}
