<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetStudentGradeAverage;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Query\QueryInterface;

final class GetStudentGradeAverageQuery implements QueryInterface
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
