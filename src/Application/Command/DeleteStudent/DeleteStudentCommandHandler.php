<?php

namespace StudentsGradesApi\Application\Command\DeleteStudent;

use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
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
            return new DeleteStudentCommandResponse();
        }

        if (null === $student = $this->studentRepository->get($command->getStudentUuid())) {
            return new DeleteStudentCommandResponse();
        }

        $this->studentRepository->delete($student);

        return new DeleteStudentCommandResponse($student->getUuid());
    }

    public static function listenTo(): string
    {
        return DeleteStudentCommand::class;
    }
}
