<?php

namespace StudentsGradesApi\Application\Command\AddGradeToStudent;

use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Application\Command\UpdateStudent\UpdateStudentCommandResponse;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;
use StudentsGradesApi\Domain\ValueObject\Grade;

/**
 * @implements CommandHandlerInterface<AddGradeToStudentCommand>
 */
final class AddGradeToStudentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    public function handle(CommandInterface $command): CommandResponseInterface
    {
        if (!$command instanceof AddGradeToStudentCommand) {
            return new UpdateStudentCommandResponse();
        }

        if (null === $student = $this->studentRepository->get($command->getStudentUuid())) {
            return new UpdateStudentCommandResponse();
        }

        if (!$this->isStudentGradeValueValid($command->getStudentGradeValue())) {
            return new UpdateStudentCommandResponse();
        }

        $student->addGrade(new Grade($command->getStudentGradeSubject(), $command->getStudentGradeValue()));

        $this->studentRepository->add($student);

        return new AddGradeToStudentCommandResponse($student->getUuid());
    }

    public static function listenTo(): string
    {
        return AddGradeToStudentCommand::class;
    }

    private function isStudentGradeValueValid(int $studentGradeValue): bool
    {
        return $studentGradeValue >= 0 && $studentGradeValue < 21;
    }
}
