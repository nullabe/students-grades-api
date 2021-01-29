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

        $this->assertArrayHasKey('gradeAverage', $response);

        $this->assertEquals(16.5, $response['gradeAverage']);
    }
}
