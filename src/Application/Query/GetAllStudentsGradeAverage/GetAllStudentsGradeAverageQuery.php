<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Application\Query\QueryInterface;

final class GetAllStudentsGradeAverageQuery implements QueryInterface
{
    /**
     * @param array<int, UuidInterface> $uuid
     */
    public function __construct(
        private array $uuid
    ) {
    }

    /**
     * @return array<int, UuidInterface>
     */
    public function getUuid(): array
    {
        return $this->uuid;
    }
}
