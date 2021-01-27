<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Integration\HttpApi\Controller\Delete;

use StudentsGradesApi\Tests\Utils\TestCase\HttpApiTestCase;

final class DeleteStudentControllerTest extends HttpApiTestCase
{
    public function test_delete_student_with_invalid_uuid(): void
    {
        $client = self::createClient();

        $client->request('DELETE', '/students/yesyesyes');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_delete_student_not_found(): void
    {
        $client = self::createClient();

        $client->request('DELETE', '/students/4ea27890-2916-4971-8ff8-a33e761ca8dd');

        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_delete_student(): void
    {
        $client = self::createClient();

        $client->request('DELETE', '/students/eb6406cf-432d-4944-8122-a8dfb6ccdf4e');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        if (false === $contentResponse = $client->getResponse()->getContent()) {
            throw new \Exception('Response should not be null');
        }

        $response = json_decode($contentResponse, true);

        $this->assertArrayHasKey('uuid', $response);

        $studentDoctrineEntity = $this->getStudentDoctrineObjectRepository($client)->findOneBy(['uuid' => 'eb6406cf-432d-4944-8122-a8dfb6ccdf4e']);

        $this->assertNull($studentDoctrineEntity);
    }
}
