<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Command\DeleteStudent;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Command\CommandInterface;

final class DeleteStudentCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $uuid
    ) {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
