<?php

namespace StudentsGradesApi\Tests\Integration\HttpApi;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetIndexTest extends WebTestCase
{
    public function test_index(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals('{}', $client->getResponse()->getContent());
    }
}
