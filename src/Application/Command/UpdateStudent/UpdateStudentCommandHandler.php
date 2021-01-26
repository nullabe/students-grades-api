<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\UpdateStudent;

use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Application\Exception\InvalidCommandException;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
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
            throw new InvalidCommandException();
        }

        if (null === $student = $this->studentRepository->get($command->getUuid())) {
            throw new StudentNotFoundException();
        }

        if (null !== $firstName = $command->getFirstName()) {
            $student->setFirstName($firstName);
        }

        if (null !== $lastName = $command->getLastName()) {
            $student->setLastName($lastName);
        }

        if (null !== $birthDate = $command->getBirthDate()) {
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
