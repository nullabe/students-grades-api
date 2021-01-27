<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\ModelTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\ValueObject\Grade;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Exception\NullStudentDoctrineEntityPropertyException;

final class StudentModelTransformer
{
    public static function toDomainModel(StudentDoctrineEntity $studentDoctrineEntity): Student
    {
        if (null === $uuid = $studentDoctrineEntity->getUuid()) {
            throw new NullStudentDoctrineEntityPropertyException('uuid should not be null.');
        }

        if (null === $firstName = $studentDoctrineEntity->getFirstName()) {
            throw new NullStudentDoctrineEntityPropertyException('firstName should not be null.');
        }

        if (null === $lastName = $studentDoctrineEntity->getLastName()) {
            throw new NullStudentDoctrineEntityPropertyException('lastName should not be null.');
        }

        if (null === $birthDate = $studentDoctrineEntity->getBirthDate()) {
            throw new NullStudentDoctrineEntityPropertyException('birthDate should not be null.');
        }

        return new Student(Uuid::fromString($uuid), $firstName, $lastName, $birthDate, self::fetchGradesFromStudentDoctrineEntity($studentDoctrineEntity));
    }

    public static function toDoctrineEntity(Student $student, ?StudentDoctrineEntity $studentDoctrineEntity = null): StudentDoctrineEntity
    {
        if (null === $studentDoctrineEntity) {
            $studentDoctrineEntity = (new StudentDoctrineEntity())->setUuid($student->getUuid()->toString());
        }

        self::setGradesToStudentDoctrineEntity($studentDoctrineEntity, $student->getGrades());

        return $studentDoctrineEntity
            ->setFirstName($student->getFirstName())
            ->setLastName($student->getLastName())
            ->setBirthDate($student->getBirthDate())
        ;
    }

    /**
     * @return array<int, Grade>
     */
    private static function fetchGradesFromStudentDoctrineEntity(StudentDoctrineEntity $studentDoctrineEntity): array
    {
        $grades = [];

        foreach ($studentDoctrineEntity->getGrades() as $grade) {
            $grades[] = GradeModelTransformer::toDomainModel($grade);
        }

        return $grades;
    }

    /**
     * @param array<int, Grade> $grades
     */
    private static function setGradesToStudentDoctrineEntity(StudentDoctrineEntity $studentDoctrineEntity, array $grades): void
    {
        // Remove all existing grades.
        $studentDoctrineEntity->setGrades(new ArrayCollection());

        foreach ($grades as $grade) {
            $studentDoctrineEntity->addGrade(GradeModelTransformer::toDoctrineEntity($grade, $studentDoctrineEntity));
        }
    }
}
