<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
use StudentsGradesApi\Application\Query\GetStudentGradeAverage\GetStudentGradeAverageQuery;
use StudentsGradesApi\Application\Query\GetStudentGradeAverage\GetStudentGradeAverageQueryHandlerInterface;
use StudentsGradesApi\Application\Query\GetStudentGradeAverage\GetStudentGradeAverageViewModel;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\ModelTransformer\StudentModelTransformer;

final class GetStudentGradeAverageQueryHandler implements GetStudentGradeAverageQueryHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function handle(GetStudentGradeAverageQuery $getStudentGradeAverageQuery): GetStudentGradeAverageViewModel
    {
        $studentDoctrineEntity = $this->entityManager->getRepository(StudentDoctrineEntity::class)->findOneBy(['uuid' => $getStudentGradeAverageQuery->getUuid()->toString()]);

        if (null === $studentDoctrineEntity) {
            throw new StudentNotFoundException();
        }

        $student = StudentModelTransformer::toDomainModel($studentDoctrineEntity);

        return new GetStudentGradeAverageViewModel($student);
    }
}
