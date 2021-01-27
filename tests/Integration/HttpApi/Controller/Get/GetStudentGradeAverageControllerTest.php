<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Integration\HttpApi\Controller\Get;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GetStudentGradeAverageControllerTest extends WebTestCase
{
    public function test_get_student_grade_average_with_invalid_uuid(): void
    {
        $client = self::createClient();

        $client->request('GET', '/students/yesyesyes/grades/average');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_get_student_grade_average_not_found(): void
    {
        $client = self::createClient();

        $client->request('GET', '/students/4ea27890-2916-4971-8ff8-a33e761ca8dd/grades/average');

        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_get_student_grade_average(): void
    {
        $client = self::createClient();

        $client->request('GET', '/students/ae13ebec-aec9-41e3-ac66-ea218cf89f7d/grades/average');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        if (false === $contentResponse = $client->getResponse()->getContent()) {
            throw new \Exception('Response should not be null');
        }

        $response = json_decode($contentResponse, true);

        $this->assertArrayHasKey('uuid', $response);
        $this->assertArrayHasKey('gradeAverage', $response);

        $this->assertEquals('ae13ebec-aec9-41e3-ac66-ea218cf89f7d', $response['uuid']);
        $this->assertEquals(16, $response['gradeAverage']);
    }
}
