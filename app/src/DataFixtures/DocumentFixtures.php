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
        foreach ($documents as [$documentTypes, $user])
        {
            $document = new Document();
            $document->setUser($this->getReference($user))
                ->setDocumentType($this->getReference($documentTypes));

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
            ],
            [
                DocumentTypesFixtures::RENTAL_AGREEMENT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENT_GUARANTEE_AGREEMENT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENT_GUARANTEE_AGREEMENT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::SUB_LETTING_AGREEMENT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::SUB_LETTING_AGREEMENT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENTAL_AGREEMENT_AMENDMENT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENTAL_AGREEMENT_AMENDMENT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENT_RECEIPT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENT_RECEIPT,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENT_INVOICE,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::RENT_INVOICE,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::LATE_PAYMENT_LETTER,
                UserFixtures::USER_REFERENCE,
            ],
            [
                DocumentTypesFixtures::LATE_PAYMENT_LETTER,
                UserFixtures::USER_REFERENCE,
            ],

        ];
    }


}
