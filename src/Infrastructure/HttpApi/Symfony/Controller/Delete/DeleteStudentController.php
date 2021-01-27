<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Delete;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\DeleteStudent\DeleteStudentCommand;
use StudentsGradesApi\Application\Command\DeleteStudent\DeleteStudentCommandHandler;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class DeleteStudentController extends AbstractController
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private DeleteStudentCommandHandler $deleteStudentCommandHandler
    ) {
    }

    #[Route(['path' => '/students/{uuid}', 'methods' => ['DELETE']])]
    public function updateStudent(string $uuid): JsonResponse
    {
        try {
            $updateStudentCommand = $this->denormalizer->denormalize(['uuid' => Uuid::fromString($uuid)], DeleteStudentCommand::class);

            $commandResponse = $this->deleteStudentCommandHandler->handle($updateStudentCommand);
        } catch (\Exception $e) {
            return JsonResponseFactory::fromException($e);
        }

        return JsonResponseFactory::fromCommandReponse($commandResponse, Response::HTTP_OK);
    }
}
