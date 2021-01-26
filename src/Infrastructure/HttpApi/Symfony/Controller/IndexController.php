<?php

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', 'GET')]
    public function index(): JsonResponse
    {
        return new JsonResponse();
    }
}
