<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Post;

use StudentsGradesApi\Application\Command\AddStudent\AddStudentCommand;
use StudentsGradesApi\Application\Command\AddStudent\AddStudentCommandHandler;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class AddStudentController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private AddStudentCommandHandler $addStudentCommandHandler
    ) {
    }

    #[Route('/students', 'POST')]
    public function addStudent(Request $request): JsonResponse
    {
        try {
            $addStudentCommand = $this->serializer->deserialize($request->getContent(), AddStudentCommand::class, 'json');

            $commandResponse = $this->addStudentCommandHandler->handle($addStudentCommand);
        } catch (\Exception $e) {
            return JsonResponseFactory::fromException($e);
        }

        return JsonResponseFactory::fromCommandReponse($commandResponse, Response::HTTP_CREATED);
    }
}
