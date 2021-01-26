<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use StudentsGradesApi\Domain\Model\Student;
use StudentsGradesApi\Domain\Repository\StudentRepositoryInterface;
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
        $student = $this->entityManager->getRepository(StudentDoctrineEntity::class)->findOneBy(['uuid' => $uuid]);

        if (null !== $student) {
            return StudentModelTransformer::toDomainModel($student);
        }

        return null;
    }

    public function add(Student $student): void
    {
        $this->entityManager->persist(StudentModelTransformer::toDoctrineEntity($student));
        $this->entityManager->flush();
    }

    public function delete(Student $student): void
    {
        if (null === $studentDoctrineEntity = $this->get($student->getUuid())) {
            return;
        }

        $this->entityManager->remove($studentDoctrineEntity);
        $this->entityManager->flush();
    }
}
