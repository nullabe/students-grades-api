<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\AddGradeToStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandResponseInterface;

final class AddGradeToStudentCommandResponse implements CommandResponseInterface
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
