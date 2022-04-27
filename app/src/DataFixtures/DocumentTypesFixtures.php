<?php

namespace App\DataFixtures;

use App\Entity\DocumentTypes;
use App\Enum\DocumentTypesFormat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DocumentTypesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $documentTypes = $this->availableDocumentTypes();

        foreach ($documentTypes as [$name, $format, $esigned, $email, $post, $updated])
        {
            $documentType = new DocumentTypes();
            $documentType->setName($name)
                         ->setFormat($format)
                         ->setEsigned($esigned)
                         ->setEmail($email)
                         ->setPost($post)
                         ->setUpdated($updated);

            $manager->persist($documentType);
        }

        $manager->flush();
    }

    /**
     * @return array[]
     */
    private function availableDocumentTypes(): array
    {
        return [
            [
                'Rental agreement', // name
                DocumentTypesFormat::FORMAT_CONTRACT, // format
                true, // esigned
                true, // email
                false, // post
                true // updated
            ],
            [
                'Rent guarantee agreement',
                DocumentTypesFormat::FORMAT_CONTRACT,
                true,
                true,
                false,
                true
            ],
            [
                'Sub-letting agreement',
                DocumentTypesFormat::FORMAT_CONTRACT,
                true,
                true,
                false,
                true
            ],
            [
                'Rental agreement amendment',
                DocumentTypesFormat::FORMAT_CONTRACT,
                true,
                true,
                false,
                true
            ],
            [
                'Rent receipt',
                DocumentTypesFormat::FORMAT_LETTER,
                false,
                true,
                true,
                true
            ],
            [
                'Rent invoice',
                DocumentTypesFormat::FORMAT_LETTER,
                false,
                true,
                true,
                true
            ],
            [
                'Late payment letter',
                DocumentTypesFormat::FORMAT_LETTER,
                false,
                true,
                true,
                true
            ],
        ];
    }

}
