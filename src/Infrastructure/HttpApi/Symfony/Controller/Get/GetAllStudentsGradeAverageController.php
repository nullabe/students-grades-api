<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Get;

use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageQuery;
use StudentsGradesApi\Application\Query\GetAllStudentsGradeAverage\GetAllStudentsGradeAverageQueryHandlerInterface;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
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
        try {
            $getAllStudentsGradeAverageViewModel = $this->getAllStudentsGradeAverageQueryHandler->handle(new GetAllStudentsGradeAverageQuery());

            $getAllStudentsGradeAverageViewModel = $this->normalizer->normalize($getAllStudentsGradeAverageViewModel, 'array');

            if (!is_array($getAllStudentsGradeAverageViewModel)) {
                throw new NotEncodableValueException('Bad normalization');
            }
        } catch (\Exception $e) {
            return JsonResponseFactory::fromException($e);
        }

        return JsonResponseFactory::fromViewModel($getAllStudentsGradeAverageViewModel);
    }
}
