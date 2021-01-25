<?php

namespace StudentsGradesApi\Application\Command\UpdateStudent;

use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;

/**
 * @implements CommandHandlerInterface<UpdateStudentCommand>
 */
final class UpdateStudentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    public function handle(CommandInterface $command): CommandResponseInterface
    {
        if (!$command instanceof UpdateStudentCommand) {
            return new UpdateStudentCommandResponse();
        }

        if (null === $student = $this->studentRepository->get($command->getStudentUuid())) {
            return new UpdateStudentCommandResponse();
        }

        if (null !== $firstName = $command->getStudentFirstName()) {
            $student->setFirstName($firstName);
        }

        if (null !== $lastName = $command->getStudentLastName()) {
            $student->setLastName($lastName);
        }

        if (null !== $birthDate = $command->getStudentBirthDate()) {
            $student->setBirthDate($birthDate);
        }

        $this->studentRepository->add($student);

        return new UpdateStudentCommandResponse($student->getUuid());
    }

    public static function listenTo(): string
    {
        return UpdateStudentCommand::class;
    }
}
