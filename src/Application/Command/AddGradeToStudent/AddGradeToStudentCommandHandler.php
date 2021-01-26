<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\AddGradeToStudent;

use StudentsGradesApi\Application\Command\CommandHandlerInterface;
use StudentsGradesApi\Application\Command\CommandInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Application\Exception\InvalidCommandException;
use StudentsGradesApi\Application\Exception\InvalidGradeException;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
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
            throw new InvalidCommandException();
        }

        if (null === $student = $this->studentRepository->get($command->getUuid())) {
            throw new StudentNotFoundException();
        }

        if (!$this->isStudentGradeValueValid($command->getGradeValue())) {
            throw new InvalidGradeException();
        }

        $student->addGrade(new Grade($command->getGradeSubject(), $command->getGradeValue()));

        $this->studentRepository->add($student);

        return new AddGradeToStudentCommandResponse($student->getUuid());
    }

    public static function listenTo(): string
    {
        return AddGradeToStudentCommand::class;
    }

    private function isStudentGradeValueValid(float $studentGradeValue): bool
    {
        return $studentGradeValue >= 0 && $studentGradeValue < 21;
    }
}
