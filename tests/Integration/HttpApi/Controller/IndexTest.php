<?php

declare(strict_types=1);

namespace StudentsGradesApi\Tests\Integration\HttpApi\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class IndexTest extends WebTestCase
{
    public function test_index(): void
    {
        $client = self::createClient();

        $client->request('GET', '/');

        $this->assertEquals('{}', $client->getResponse()->getContent());
    }
}
