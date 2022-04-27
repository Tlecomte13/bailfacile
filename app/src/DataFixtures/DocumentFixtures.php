<?php

namespace App\DataFixtures;

use App\Entity\Document;
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
        $document = new Document();
        $document->setUser($this->getReference(UserFixtures::USER_REFERENCE))
                 ->setDocumentType($this->getReference(DocumentTypesFixtures::RENTAL_AGREEMENT));

        $manager->persist($document);

        $manager->flush();
    }


}
