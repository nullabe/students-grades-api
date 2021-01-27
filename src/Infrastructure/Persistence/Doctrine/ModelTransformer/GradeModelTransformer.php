<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\ModelTransformer;

use StudentsGradesApi\Domain\ValueObject\Grade;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\GradeDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Exception\NullGradeDoctrineEntityPropertyException;

final class GradeModelTransformer
{
    public static function toDomainModel(GradeDoctrineEntity $gradeDoctrineEntity): Grade
    {
        if (null === $subject = $gradeDoctrineEntity->getSubject()) {
            throw new NullGradeDoctrineEntityPropertyException('subject should not be null.');
        }

        if (null === $value = $gradeDoctrineEntity->getValue()) {
            throw new NullGradeDoctrineEntityPropertyException('value should not be null.');
        }

        return new Grade($subject, $value);
    }

    public static function toDoctrineEntity(Grade $grade, ?StudentDoctrineEntity $studentDoctrineEntity = null): GradeDoctrineEntity
    {
        return (new GradeDoctrineEntity())
            ->setSubject($grade->getSubject())
            ->setValue($grade->getValue())
            ->setStudent($studentDoctrineEntity)
        ;
    }
}
