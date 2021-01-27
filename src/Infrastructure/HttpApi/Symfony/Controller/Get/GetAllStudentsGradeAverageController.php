<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Get;

use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageQuery;
use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageQueryHandlerInterface;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GetAllStudentsGradeAverageController extends AbstractController
{
    public function __construct(
        private NormalizerInterface $normalizer,
        private GetAllStudentsGradeAverageQueryHandlerInterface $getAllStudentsGradeAverageQueryHandler
    ) {
    }

    #[Route(['path' => '/students/grades/average', 'methods' => ['GET']])]
    public function getAllStudentsGradeAverage(): JsonResponse
    {
        $studentGradeAverageViewModels = [];

        foreach ($this->getAllStudentsGradeAverageQueryHandler->handle(new GetAllStudentsGradeAverageQuery()) as $studentGradeAverageViewModel) {
            $studentGradeAverageViewModel = $this->normalizer->normalize($studentGradeAverageViewModel, 'array');

            if (!is_array($studentGradeAverageViewModel)) {
                continue;
            }

            $studentGradeAverageViewModels[] = $studentGradeAverageViewModel;
        }

        return JsonResponseFactory::fromViewModel($studentGradeAverageViewModels);
    }
}
