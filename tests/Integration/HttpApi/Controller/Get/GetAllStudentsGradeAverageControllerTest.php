<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Integration\HttpApi\Controller\Get;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GetAllStudentsGradeAverageControllerTest extends WebTestCase
{
    public function test_get_all_student_grade_average(): void
    {
        $client = self::createClient();

        $client->request('GET', '/students/grades/average');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        if (false === $contentResponse = $client->getResponse()->getContent()) {
            throw new \Exception('Response should not be null');
        }

        $response = json_decode($contentResponse, true);

        $this->assertCount(2, $response);

        $this->assertArrayHasKey(0, $response);
        $this->assertArrayHasKey(1, $response);

        $this->assertArrayHasKey('uuid', $response[0]);
        $this->assertArrayHasKey('uuid', $response[1]);
        $this->assertArrayHasKey('gradeAverage', $response[0]);
        $this->assertArrayHasKey('gradeAverage', $response[1]);

        $this->assertEquals('eb6406cf-432d-4944-8122-a8dfb6ccdf4e', $response[0]['uuid']);
        $this->assertEquals('ae13ebec-aec9-41e3-ac66-ea218cf89f7d', $response[1]['uuid']);

        $this->assertEquals(17, $response[0]['gradeAverage']);
        $this->assertEquals(16, $response[1]['gradeAverage']);
    }
}
