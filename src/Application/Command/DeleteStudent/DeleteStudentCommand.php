<?php

namespace StudentsGradesApi\Application\Command\DeleteStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandInterface;

final class DeleteStudentCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $studentUuid
    ) {
    }

    public function getStudentUuid(): UuidInterface
    {
        return $this->studentUuid;
    }
}
