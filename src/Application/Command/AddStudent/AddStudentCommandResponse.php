<?php

namespace StudentsGradesApi\Application\Command\AddStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;

final class AddStudentCommandResponse implements CommandResponseInterface
{
    public function __construct(
        private ?UuidInterface $value = null
    ) {
    }

    public function getValue(): ?UuidInterface
    {
        return $this->value;
    }
}
