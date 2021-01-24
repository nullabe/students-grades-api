<?php

namespace StudentsGradesApi\Application\Command;

use Ramsey\Uuid\UuidInterface;

interface CommandResponseInterface
{
    public function getValue(): ?UuidInterface;
}
