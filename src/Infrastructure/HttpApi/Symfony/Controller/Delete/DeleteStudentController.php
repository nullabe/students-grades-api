<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Controller\Delete;

use StudentsGradesApi\Application\Command\DeleteStudent\DeleteStudentCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DeleteStudentController extends AbstractController
{
    public function __construct(
        private DeleteStudentCommandHandler $deleteStudentCommandHandler
    ) {
    }
}
