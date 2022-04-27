<?php

namespace App\Tests\document\post;

use App\Entity\User;
use App\Tests\utils\DatabaseTestCase;

class DocumentPostTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testPostSuccess(): void
    {
        static::createClient()->request('POST', '/api/documents', [
            'json' => [
                'documentType' => [
                    'slug' => "rent_guarantee_agreement"
                ],
                'user' => [
                    'id' => $this->entityManager->getRepository(User::class)->findAll()[0]->getId()
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testPostWithoutSlug(): void
    {
        $response = static::createClient()->request('POST', '/api/documents', [
            'json' => [
                'user' => [
                    'id' => $this->entityManager->getRepository(User::class)->findAll()[0]->getId()
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame($response->getStatusCode(), 400);
    }

    public function testPostWithoutUser(): void
    {
        $response = static::createClient()->request('POST', '/api/documents', [
            'json' => [
                'documentType' => [
                    'slug' => "rent_guarantee_agreement"
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame($response->getStatusCode(), 400);
    }
}