<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\DeleteStudent;

use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Application\Exception\InvalidCommandException;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;

/**
 * @implements CommandHandlerInterface<DeleteStudentCommand>
 */
final class DeleteStudentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    public function handle(CommandInterface $command): CommandResponseInterface
    {
        if (!$command instanceof DeleteStudentCommand) {
            throw new InvalidCommandException();
        }

        if (null === $student = $this->studentRepository->get($command->getUuid())) {
            throw new StudentNotFoundException();
        }

        $this->studentRepository->delete($student);

        return new DeleteStudentCommandResponse($student->getUuid());
    }

    public static function listenTo(): string
    {
        return DeleteStudentCommand::class;
    }
}
