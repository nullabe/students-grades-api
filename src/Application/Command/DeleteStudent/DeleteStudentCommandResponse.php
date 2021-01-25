<?php

namespace StudentsGradesApi\Application\Command\DeleteStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;

final class DeleteStudentCommandResponse implements CommandResponseInterface
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
