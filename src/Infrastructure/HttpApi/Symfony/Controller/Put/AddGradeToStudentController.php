<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Put;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\AddGradeToStudent\AddGradeToStudentCommand;
use StudentsGradesApi\Application\Command\AddGradeToStudent\AddGradeToStudentCommandHandler;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class AddGradeToStudentController extends AbstractController
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private AddGradeToStudentCommandHandler $addGradeToStudentCommandHandler
    ) {
    }

    #[Route(['path' => '/students/{uuid}/grades', 'methods' => ['PUT']])]
    public function addGradeToStudent(Request $request, string $uuid): JsonResponse
    {
        try {
            $requestContent = json_decode((string) $request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $requestContent['uuid'] = Uuid::fromString($uuid);

            $addGradeToStudentCommand = $this->denormalizer->denormalize($requestContent, AddGradeToStudentCommand::class);

            $commandResponse = $this->addGradeToStudentCommandHandler->handle($addGradeToStudentCommand);
        } catch (\Exception $e) {
            return JsonResponseFactory::fromException($e);
        }

        return JsonResponseFactory::fromCommandReponse($commandResponse, Response::HTTP_OK);
    }
}
