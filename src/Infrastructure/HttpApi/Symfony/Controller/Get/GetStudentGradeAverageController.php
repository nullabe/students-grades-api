<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Get;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Query\GetStudentGradeAverage\GetStudentGradeAverageQuery;
use StudentsGradesApi\Application\Query\GetStudentGradeAverage\GetStudentGradeAverageQueryHandlerInterface;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GetStudentGradeAverageController extends AbstractController
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private NormalizerInterface $normalizer,
        private GetStudentGradeAverageQueryHandlerInterface $getStudentGradeAverageQueryHandler
    ) {
    }

    #[Route(['path' => '/students/{uuid}/grades/average', 'methods' => ['GET']])]
    public function getStudentGradeAverage(string $uuid): JsonResponse
    {
        try {
            $getStudentGradeAverageQuery = $this->denormalizer->denormalize(['uuid' => Uuid::fromString($uuid)], GetStudentGradeAverageQuery::class);

            $getStudentGradeAverageViewModel = $this->getStudentGradeAverageQueryHandler->handle($getStudentGradeAverageQuery);

            $getStudentGradeAverageViewModel = $this->normalizer->normalize($getStudentGradeAverageViewModel, 'array');

            if (!is_array($getStudentGradeAverageViewModel)) {
                throw new NotEncodableValueException('Bad normalization');
            }
        } catch (\Exception $e) {
            return JsonResponseFactory::fromException($e);
        }

        return JsonResponseFactory::fromViewModel($getStudentGradeAverageViewModel);
    }
}
