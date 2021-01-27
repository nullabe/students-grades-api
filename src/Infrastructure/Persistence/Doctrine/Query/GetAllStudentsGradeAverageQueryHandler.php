<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageQuery;
use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageQueryHandlerInterface;
use StudentsGradesApi\Application\Query\StudentGradeAverageViewModel;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\ModelTransformer\StudentModelTransformer;

final class GetAllStudentsGradeAverageQueryHandler implements GetAllStudentsGradeAverageQueryHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function handle(GetAllStudentsGradeAverageQuery $getAllStudentsGradeAverageQuery): array
    {
        $studentGradeAverageViewModels = [];

        $students = $this->entityManager->getRepository(StudentDoctrineEntity::class)->findAll();

        foreach ($students as $studentDoctrineEntity) {
            $studentGradeAverageViewModels[] = new StudentGradeAverageViewModel(StudentModelTransformer::toDomainModel($studentDoctrineEntity));
        }

        return $studentGradeAverageViewModels;
    }
}
