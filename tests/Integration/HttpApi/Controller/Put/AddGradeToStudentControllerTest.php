<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Integration\HttpApi\Controller\Put;

use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\GradeDoctrineEntity;
use StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity;
use StudentsGradesApi\Tests\Utils\TestCase\HttpApiTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

final class AddGradeToStudentControllerTest extends HttpApiTestCase
{
    public function test_add_grade_to_student_with_invalid_grade_value(): void
    {
        $client = self::createClient();

        $client->request('PUT', '/students/eb6406cf-432d-4944-8122-a8dfb6ccdf4e/grades', [], [], [], '{"gradeSubject": "Maths", "gradeValue": 21.0}');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_add_grade_to_student_with_missing_value(): void
    {
        $client = self::createClient();

        $client->request('PUT', '/students/eb6406cf-432d-4944-8122-a8dfb6ccdf4e/grades', [], [], [], '{"gradeSubject": "Maths"}');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_add_grade_to_student_with_invalid_uuid(): void
    {
        $client = self::createClient();

        $client->request('PUT', '/students/yesyesyes/grades', [], [], [], '{"gradeSubject": "Maths", "gradeValue": 18.2}');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_add_grade_to_student_not_found(): void
    {
        $client = self::createClient();

        $client->request('PUT', '/students/4ea27890-2916-4971-8ff8-a33e761ca8dd/grades', [], [], [], '{"gradeSubject": "Maths", "gradeValue": 18.2}');

        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_add_grade_to_student(): void
    {
        $client = self::createClient();

        $client->request('PUT', '/students/eb6406cf-432d-4944-8122-a8dfb6ccdf4e/grades', [], [], [], '{"gradeSubject": "Maths", "gradeValue": 18.2}');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        if (false === $contentResponse = $client->getResponse()->getContent()) {
            throw new \Exception('Response should not be null');
        }

        $response = json_decode($contentResponse, true);

        $this->assertArrayHasKey('uuid', $response);

        $this->assertStudentDoctrineEntity($client);
    }

    private function assertStudentDoctrineEntity(KernelBrowser $client): void
    {
        /** @var StudentDoctrineEntity|null $studentDoctrineEntity */
        $studentDoctrineEntity = $this->getStudentDoctrineObjectRepository($client)->findOneBy(['uuid' => 'eb6406cf-432d-4944-8122-a8dfb6ccdf4e']);

        if (null === $studentDoctrineEntity) {
            throw new \Exception('Student stored in database should not be null');
        }

        $this->assertCount(4, $studentDoctrineEntity->getGrades());

        /** @var GradeDoctrineEntity|null $grade */
        $grade = $studentDoctrineEntity->getGrades()->last();

        if (null === $grade) {
            throw new \Exception('Grade stored in database should not be null');
        }

        $this->assertEquals('Maths', $grade->getSubject());
        $this->assertEquals(18.2, $grade->getValue());
    }
}
