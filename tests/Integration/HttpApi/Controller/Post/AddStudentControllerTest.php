<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Integration\HttpApi\Controller\Post;

use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AddStudentControllerTest extends WebTestCase
{
    public function test_post_student_with_missing_values_in_request(): void
    {
        $client = self::createClient();

        $client->request('POST', '/students', [], [], [], '{"firstName": "Antoine", "birthDate": "13-11-1990"}');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_post_student_with_syntax_error_request(): void
    {
        $client = self::createClient();

        $client->request('POST', '/students', [], [], [], '{zzz"firstName": "Antoine",}');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_post_student(): void
    {
        $client = self::createClient();

        $client->request('POST', '/students', [], [], [], '{"firstName": "Antoine", "lastName": "Belluard", "birthDate": "13-11-1990"}');

        $response = $client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());

        if (false === $contentResponse = $client->getResponse()->getContent()) {
            throw new \Exception('Response should not be null');
        }

        $response = json_decode($contentResponse, true);

        $this->assertArrayHasKey('uuid', $response);

        $this->assertStudentDoctrineEntity($client, $response['uuid']);
    }

    private function assertStudentDoctrineEntity(KernelBrowser $client, string $studentUuid): void
    {
        /** @var ManagerRegistry|null $doctrineObjectManagerRegistry */
        $doctrineObjectManagerRegistry = $client
            ->getContainer()
            ->get('doctrine')
        ;

        if (null === $doctrineObjectManagerRegistry) {
            throw new \Exception('Doctrine manager registry should not be null');
        }

        $studentDoctrineEntityRepository = $doctrineObjectManagerRegistry
            ->getRepository(StudentDoctrineEntity::class)
        ;

        /** @var StudentDoctrineEntity|null $studentDoctrineEntity */
        $studentDoctrineEntity = $studentDoctrineEntityRepository->findOneBy(['uuid' => $studentUuid]);

        if (null === $studentDoctrineEntity) {
            throw new \Exception('Student stored in database should not be null');
        }

        $this->assertEquals('Antoine', $studentDoctrineEntity->getFirstName());
        $this->assertEquals('Belluard', $studentDoctrineEntity->getLastName());
        $this->assertEquals(new \DateTime('13-11-1990'), $studentDoctrineEntity->getBirthDate());
    }
}
