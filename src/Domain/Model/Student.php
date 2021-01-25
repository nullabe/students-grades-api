<?php

declare(strict_types=1);

namespace StudentsGradesApi\Domain\Model;

use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\ValueObject\Grade;

final class Student
{
    /**
     * @param array<int, Grade> $grades
     */
    public function __construct(
        private UuidInterface $uuid,
        private string $firstName,
        private string $lastName,
        private \DateTimeInterface $birthDate,
        private array $grades = []
    ) {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return array<int, Grade>
     */
    public function getGrades(): array
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): self
    {
        $this->grades[] = $grade;

        return $this;
    }

    public function getGradeAverage(): float
    {
        if (0 === count($this->getGrades())) {
            return 0.0;
        }

        $grades = array_sum(array_map(fn (Grade $grade) => $grade->getValue(), $this->getGrades()));

        return $grades / count($this->getGrades());
    }
}
