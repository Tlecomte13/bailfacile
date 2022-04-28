<?php

namespace App\Tests\document\update;

use App\Entity\Document;
use App\Entity\DocumentTypes;
use App\Tests\utils\DatabaseTestCase;

class DocumentUpdateTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUpdateSuccess(): void
    {

        $documentType = $this->entityManager->getRepository(DocumentTypes::class)->findOneBy([
            'slug' => 'rental_agreement'
        ]);

        $document = $this->entityManager->getRepository(Document::class)->findOneBy([
           'documentType' => $documentType
        ]);

        $response = static::createClient()->request('PATCH', '/api/documents/'.$document->getId() , [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'esign' => true
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertTrue($response->toArray()['locked']);
    }

    public function testTryToSignDocumentNotPermit()
    {
        $documentType = $this->entityManager->getRepository(DocumentTypes::class)->findOneBy([
            'slug' => 'rent_receipt'
        ]);

        $document = $this->entityManager->getRepository(Document::class)->findOneBy([
            'documentType' => $documentType
        ]);

        $response = static::createClient()->request('PATCH', '/api/documents/'.$document->getId() , [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'esign' => true
            ]
        ]);

        $this->assertResponseStatusCodeSame($response->getStatusCode(), 403);
    }
}