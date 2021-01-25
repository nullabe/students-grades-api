<?php

declare(strict_types=1);

namespace StudentsGradesApi\Application\Query;

use Ramsey\Uuid\UuidInterface;

final class GetAllStudentsGradeAverageQuery implements QueryInterface
{
    /**
     * @param array<int, UuidInterface> $studentsUuid
     */
    public function __construct(
        private array $studentsUuid
    ) {
    }

    /**
     * @return array<int, UuidInterface>
     */
    public function getStudentsUuid(): array
    {
        return $this->studentsUuid;
    }
}
