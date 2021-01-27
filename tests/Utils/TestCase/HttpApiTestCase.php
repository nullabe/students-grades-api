<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Utils\TestCase;

use Doctrine\Persistence\ObjectRepository;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class HttpApiTestCase extends WebTestCase
{
    /**
     * @return ObjectRepository<StudentDoctrineEntity>
     */
    protected function getStudentDoctrineObjectRepository(KernelBrowser $client): ObjectRepository
    {
        /** @var ManagerRegistry|null $doctrineObjectManagerRegistry */
        $doctrineObjectManagerRegistry = $client
            ->getContainer()
            ->get('doctrine')
        ;

        if (null === $doctrineObjectManagerRegistry) {
            throw new \Exception('Doctrine manager registry should not be null');
        }

        return $doctrineObjectManagerRegistry
            ->getRepository(StudentDoctrineEntity::class)
        ;
    }
}
