<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Integration\HttpApi\Controller\Post;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AddStudentControllerTest extends WebTestCase
{
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
    }
}
