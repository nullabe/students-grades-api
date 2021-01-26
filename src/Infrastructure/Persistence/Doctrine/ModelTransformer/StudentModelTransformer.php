<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\ModelTransformer;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Domain\Model\Student;
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

        return new Student(Uuid::fromString($uuid), $firstName, $lastName, $birthDate);
    }

    public static function toDoctrineEntity(Student $student): StudentDoctrineEntity
    {
        return (new StudentDoctrineEntity())
            ->setUuid($student->getUuid()->toString())
            ->setFirstName($student->getFirstName())
            ->setLastName($student->getLastName())
            ->setBirthDate($student->getBirthDate())
        ;
    }
}
