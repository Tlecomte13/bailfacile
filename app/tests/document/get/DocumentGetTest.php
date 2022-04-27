<?php

namespace App\Tests\document\get;

use App\Tests\utils\DatabaseTestCase;

class DocumentGetTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testLimitTenResults(): void
    {
        $response = static::createClient()->request('GET', '/api/documents');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(count($response->toArray()['hydra:member']), 10);
    }
}