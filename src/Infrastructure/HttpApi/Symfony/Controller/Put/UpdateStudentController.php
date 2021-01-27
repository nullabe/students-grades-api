<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Put;

use Ramsey\Uuid\Uuid;
use StudentsGradesApi\Application\Command\UpdateStudent\UpdateStudentCommand;
use StudentsGradesApi\Application\Command\UpdateStudent\UpdateStudentCommandHandler;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateStudentController extends AbstractController
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private UpdateStudentCommandHandler $updateStudentCommandHandler
    ) {
    }

    #[Route('/students/{uuid}', 'PUT')]
    public function addStudent(Request $request, string $uuid): JsonResponse
    {
        try {
            $requestContent = json_decode((string) $request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $requestContent['uuid'] = Uuid::fromString($uuid);

            $updateStudentCommand = $this->denormalizer->denormalize($requestContent, UpdateStudentCommand::class);

            $commandResponse = $this->updateStudentCommandHandler->handle($updateStudentCommand);
        } catch (\Exception $e) {
            return JsonResponseFactory::fromException($e);
        }

        return JsonResponseFactory::fromCommandReponse($commandResponse, Response::HTTP_OK);
    }

    //StudentNotFoundException
}
