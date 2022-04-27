<?php

namespace App\DataFixtures;

use App\Entity\DocumentTypes;
use App\Enum\DocumentTypesFormat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DocumentTypesFixtures extends Fixture
{
    public const RENTAL_AGREEMENT = 'Rental agreement';
    public const RENT_GUARANTEE_AGREEMENT = 'Rent guarantee agreement';
    public const SUB_LETTING_AGREEMENT = 'Sub letting agreement';
    public const RENTAL_AGREEMENT_AMENDMENT = 'Rental agreement amendment';
    public const RENT_RECEIPT = 'Rent receipt';
    public const RENT_INVOICE = 'Rent invoice';
    public const LATE_PAYMENT_LETTER = 'Late payment letter';

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
            $this->addReference($name, $documentType);
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

                self::RENTAL_AGREEMENT, // name
                DocumentTypesFormat::FORMAT_CONTRACT, // format
                true, // esigned
                true, // email
                false, // post
                true // updated
            ],
            [
                self::RENT_GUARANTEE_AGREEMENT,
                DocumentTypesFormat::FORMAT_CONTRACT,
                true,
                true,
                false,
                true
            ],
            [
                self::SUB_LETTING_AGREEMENT,
                DocumentTypesFormat::FORMAT_CONTRACT,
                true,
                true,
                false,
                true
            ],
            [
                self::RENTAL_AGREEMENT_AMENDMENT,
                DocumentTypesFormat::FORMAT_CONTRACT,
                true,
                true,
                false,
                true
            ],
            [
                self::RENT_RECEIPT,
                DocumentTypesFormat::FORMAT_LETTER,
                false,
                true,
                true,
                true
            ],
            [
                self::RENT_INVOICE,
                DocumentTypesFormat::FORMAT_LETTER,
                false,
                true,
                true,
                true
            ],
            [
                self::LATE_PAYMENT_LETTER,
                DocumentTypesFormat::FORMAT_LETTER,
                false,
                true,
                true,
                true
            ],
        ];
    }

}
