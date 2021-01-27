<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\GradeDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\ModelTransformer\StudentModelTransformer;

final class StudentDoctrineRepository implements StudentRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function get(UuidInterface $uuid): ?Student
    {
        if (null !== $student = $this->getStudentByUuid($uuid)) {
            return StudentModelTransformer::toDomainModel($student);
        }

        return null;
    }

    public function add(Student $student): void
    {
        $studentDoctrineEntity = StudentModelTransformer::toDoctrineEntity($student, $this->getStudentByUuid($student->getUuid()));

        // Usefull for updating grades, we don't know here which are new ones, so we remove them all.
        $this->removeStudentGrades($studentDoctrineEntity);

        $this->entityManager->persist($studentDoctrineEntity);
        $this->entityManager->flush();
    }

    public function delete(Student $student): void
    {
        if (null === $studentDoctrineEntity = $this->getStudentByUuid($student->getUuid())) {
            return;
        }

        $this->entityManager->remove($studentDoctrineEntity);
        $this->entityManager->flush();
    }

    private function getStudentByUuid(UuidInterface $uuid): ?StudentDoctrineEntity
    {
        return $this->entityManager->getRepository(StudentDoctrineEntity::class)->findOneBy(['uuid' => $uuid->toString()]);
    }

    private function removeStudentGrades(StudentDoctrineEntity $studentDoctrineEntity): void
    {
        $grades = $this->entityManager->getRepository(GradeDoctrineEntity::class)->findBy(['student' => $studentDoctrineEntity]);

        foreach ($grades as $grade) {
            $this->entityManager->remove($grade);
        }

        $this->entityManager->flush();
    }
}
