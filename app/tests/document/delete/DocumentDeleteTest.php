<?php

namespace App\Tests\document\delete;

use App\Entity\Document;
use App\Entity\DocumentTypes;
use App\Tests\utils\DatabaseTestCase;

class DocumentDeleteTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testDeleteSuccess(): void
    {
        $document = $this->entityManager->getRepository(Document::class)->findOneBy([
           'locked' => null
        ]);

        static::createClient()->request('DELETE', '/api/documents/'.$document->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testTryToDeleteDocumentLocked()
    {
        $document = $this->entityManager->getRepository(Document::class)->findOneBy([
            'locked' => true
        ]);

        $response = static::createClient()->request('PATCH', '/api/documents/'.$document->getId());

        $this->assertResponseStatusCodeSame($response->getStatusCode(), 403);
    }
}