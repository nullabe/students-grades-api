<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query;

use Ramsey\Uuid\UuidInterface;

final class GetStudentGradeAverageQuery implements QueryInterface
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
