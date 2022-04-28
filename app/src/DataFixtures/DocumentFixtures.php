<?php

namespace App\DataFixtures;

use App\Entity\Document;
use App\Entity\DocumentTypes;
use App\Enum\DocumentTypesFormat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DocumentFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            DocumentTypesFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $documents = $this->availableDocument();
        foreach ($documents as [$documentTypes, $user, $locked])
        {
            $document = new Document();
            $document->setUser($this->getReference($user))
                ->setDocumentType($this->getReference($documentTypes))
                ->setLocked($locked);

            $manager->persist($document);
        }

        $manager->flush();
    }

    /**
     * @return array[]
     */
    private function availableDocument(): array
    {
        return [
            [
                DocumentTypesFixtures::RENTAL_AGREEMENT,
                UserFixtures::USER_REFERENCE,
                null
            ],
            [
                DocumentTypesFixtures::RENTAL_AGREEMENT,
                UserFixtures::USER_REFERENCE,
                null
            ],
            [
                DocumentTypesFixtures::RENT_GUARANTEE_AGREEMENT,
                UserFixtures::USER_REFERENCE,
                null
            ],
            [
                DocumentTypesFixtures::RENT_GUARANTEE_AGREEMENT,
                UserFixtures::USER_REFERENCE,
                null
            ],
            [
                DocumentTypesFixtures::SUB_LETTING_AGREEMENT,
                UserFixtures::USER_REFERENCE,
                true
            ],
            [
                DocumentTypesFixtures::SUB_LETTING_AGREEMENT,
                UserFixtures::USER_REFERENCE,
                null
            ],
            [
                DocumentTypesFixtures::RENTAL_AGREEMENT_AMENDMENT,
                UserFixtures::USER_REFERENCE,
                null
            ],
            [
                DocumentTypesFixtures::RENTAL_AGREEMENT_AMENDMENT,
                UserFixtures::USER_REFERENCE,
                null
            ],
            [
                DocumentTypesFixtures::RENT_RECEIPT,
                UserFixtures::USER_REFERENCE,
                true
            ],
            [
                DocumentTypesFixtures::RENT_RECEIPT,
                UserFixtures::USER_REFERENCE,
                true
            ],
            [
                DocumentTypesFixtures::RENT_INVOICE,
                UserFixtures::USER_REFERENCE,
                true
            ],
            [
                DocumentTypesFixtures::RENT_INVOICE,
                UserFixtures::USER_REFERENCE,
                true
            ],
            [
                DocumentTypesFixtures::LATE_PAYMENT_LETTER,
                UserFixtures::USER_REFERENCE,
                true
            ],
            [
                DocumentTypesFixtures::LATE_PAYMENT_LETTER,
                UserFixtures::USER_REFERENCE,
                true
            ],

        ];
    }


}
